<?php

namespace App\Http\Controllers\GateLog;

use App\Mail\GateLogOtpMail;
use App\Models\Gatelog\AllowedEmail;
use App\Models\Gatelog\EmailOtp;
use App\Models\Gatelog\GatelogUser;
use App\Models\Gatelog\PersonalAccessToken;
use App\Models\Gatelog\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\NewAccessToken;

class GateLogAuthController extends \App\Http\Controllers\Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            "school_code" => ["required", "string"],
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255"],
            "password" => ["required", "string", "min:8"],
        ]);

        $school = School::query()
            ->where("code", $data["school_code"])
            ->where("is_active", true)
            ->first();
        if (!$school) {
            return response()->json(["message" => "School not found or inactive."], 422);
        }

        $email = strtolower($data["email"]);

        $allowed = AllowedEmail::query()
            ->where("school_id", $school->id)
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$allowed) {
            return response()->json(["message" => "Email is not allowed for this school."], 422);
        }

        if ($allowed->is_used) {
            return response()->json(["message" => "Email is already used."], 422);
        }

        $existing = GatelogUser::query()
            ->where("school_id", $school->id)
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if ($existing) {
            return response()->json(["message" => "Email already registered."], 422);
        }

        DB::connection("pgsql_gatelog")->transaction(function () use (
            $school,
            $data,
            $email,
            $allowed,
        ) {
            $user = GatelogUser::query()->create([
                "school_id" => $school->id,
                "name" => $data["name"],
                "email" => $email,
                "password" => $data["password"],
            ]);

            $this->issueOtp($school->id, $user->id, $email);

            $allowed->is_used = true;
            $allowed->save();
        });

        return response()->json(
            [
                "message" => "Registered. OTP was generated and should be sent to email.",
            ],
            201,
        );
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            "school_code" => ["required", "string"],
            "email" => ["required", "email"],
        ]);

        $school = School::query()
            ->where("code", $data["school_code"])
            ->where("is_active", true)
            ->first();
        if (!$school) {
            return response()->json(["message" => "School not found or inactive."], 422);
        }

        $email = strtolower($data["email"]);
        $user = GatelogUser::query()
            ->where("school_id", $school->id)
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $this->issueOtp($school->id, $user->id, $email);

        return response()->json(["message" => "OTP generated."]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            "school_code" => ["required", "string"],
            "email" => ["required", "email"],
            "otp" => ["required", "digits:6"],
        ]);

        $school = School::query()
            ->where("code", $data["school_code"])
            ->where("is_active", true)
            ->first();
        if (!$school) {
            return response()->json(["message" => "School not found or inactive."], 422);
        }

        $email = strtolower($data["email"]);
        $user = GatelogUser::query()
            ->where("school_id", $school->id)
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $otp = EmailOtp::query()
            ->where("school_id", $school->id)
            ->where("user_id", $user->id)
            ->whereNull("verified_at")
            ->where("expires_at", ">", Carbon::now())
            ->latest("id")
            ->first();

        if (!$otp) {
            return response()->json(["message" => "No active OTP found."], 422);
        }

        if ($otp->attempts >= 5) {
            return response()->json(["message" => "OTP attempts exceeded."], 429);
        }

        if (!Hash::check($data["otp"], $otp->code_hash)) {
            $otp->increment("attempts");
            return response()->json(["message" => "Invalid OTP."], 422);
        }

        $otp->verified_at = Carbon::now();
        $otp->save();

        $user->email_verified_at = Carbon::now();
        $user->save();

        $token = $this->createGatelogToken($user, "gatelog_mobile");

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => [
                "id" => $user->id,
                "school_id" => $user->school_id,
                "name" => $user->name,
                "email" => $user->email,
            ],
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "school_code" => ["required", "string"],
            "email" => ["required", "email"],
            "password" => ["required", "string"],
        ]);

        $school = School::query()
            ->where("code", $data["school_code"])
            ->where("is_active", true)
            ->first();
        if (!$school) {
            return response()->json(["message" => "School not found or inactive."], 422);
        }

        $email = strtolower($data["email"]);
        $user = GatelogUser::query()
            ->where("school_id", $school->id)
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$user || !Hash::check($data["password"], $user->password)) {
            return response()->json(["message" => "Invalid credentials."], 401);
        }

        if (!$user->email_verified_at) {
            return response()->json(["message" => "Email is not verified."], 403);
        }

        $token = $this->createGatelogToken($user, "gatelog_mobile");

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
        ]);
    }

    private function createGatelogToken(GatelogUser $user, string $name): string
    {
        $plainTextToken = bin2hex(random_bytes(40));

        $token = PersonalAccessToken::query()->create([
            "tokenable_type" => GatelogUser::class,
            "tokenable_id" => $user->id,
            "name" => $name,
            "token" => hash("sha256", $plainTextToken),
            "abilities" => ["*"],
        ]);

        return new NewAccessToken($token, $token->getKey() . "|" . $plainTextToken)->plainTextToken;
    }

    private function issueOtp(int $schoolId, int $userId, string $email): void
    {
        $code = (string) random_int(100000, 999999);

        EmailOtp::query()->create([
            "school_id" => $schoolId,
            "user_id" => $userId,
            "email" => $email,
            "code_hash" => Hash::make($code),
            "expires_at" => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($email)->send(new GateLogOtpMail($code));
    }
}
