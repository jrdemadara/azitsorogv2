<?php

namespace App\Http\Controllers\GateLog;

use App\Mail\GateLogOtpMail;
use App\Models\Gatelog\AllowedEmail;
use App\Models\Gatelog\GatelogUser;
use App\Models\Gatelog\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Laravel\Sanctum\NewAccessToken;

class GateLogAuthController extends \App\Http\Controllers\Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255"],
            "password" => ["required", "string", "min:8"],
        ]);

        $email = strtolower($data["email"]);

        $allowed = AllowedEmail::query()
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$allowed) {
            return response()->json(["message" => "Email is not allowed."], 422);
        }

        $existing = GatelogUser::query()
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if ($existing) {
            return response()->json(["message" => "Email already registered."], 422);
        }

        DB::connection("pgsql_gatelog")->transaction(function () use ($data, $email, $allowed) {
            $user = GatelogUser::query()->create([
                "school_id" => $allowed->school_id,
                "name" => $data["name"],
                "email" => $email,
                "password" => $data["password"],
            ]);

            $this->issueOtp((int) $allowed->school_id, $user->id, $email);
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
            "email" => ["required", "email"],
        ]);

        $email = strtolower($data["email"]);
        $user = GatelogUser::query()
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $this->issueOtp((int) $user->school_id, $user->id, $email);

        return response()->json(["message" => "OTP generated."]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email"],
            "otp" => ["required", "digits:6"],
        ]);

        $email = strtolower($data["email"]);
        $user = GatelogUser::query()
            ->whereRaw("LOWER(email) = ?", [$email])
            ->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $otpHash = Redis::get($this->otpKey($email));
        if (!$otpHash) {
            return response()->json(["message" => "No active OTP found."], 422);
        }

        $attempts = (int) (Redis::get($this->otpAttemptsKey($email)) ?? 0);
        if ($attempts >= 5) {
            return response()->json(["message" => "OTP attempts exceeded."], 429);
        }

        if (!Hash::check($data["otp"], $otpHash)) {
            $attempts = Redis::incr($this->otpAttemptsKey($email));
            if ($attempts === 1) {
                Redis::expire($this->otpAttemptsKey($email), self::OTP_TTL_SECONDS);
            }
            return response()->json(["message" => "Invalid OTP."], 422);
        }

        Redis::del($this->otpKey($email));
        Redis::del($this->otpAttemptsKey($email));

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
            "email" => ["required", "email"],
            "password" => ["required", "string"],
        ]);

        $email = strtolower($data["email"]);
        $user = GatelogUser::query()
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

        Redis::setex($this->otpKey($email), self::OTP_TTL_SECONDS, Hash::make($code));
        Redis::del($this->otpAttemptsKey($email));

        Mail::to($email)->send(new GateLogOtpMail($code));
    }

    private function otpKey(string $email): string
    {
        return "gatelog:otp:" . strtolower($email);
    }

    private function otpAttemptsKey(string $email): string
    {
        return "gatelog:otp:attempts:" . strtolower($email);
    }

    private const OTP_TTL_SECONDS = 1800;
}
