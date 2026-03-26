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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Laravel\Sanctum\NewAccessToken;

class GateLogAuthController extends \App\Http\Controllers\Controller
{
    public function register(Request $request)
    {
        try {
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
        } catch (\Throwable $e) {
            Log::error("GateLog register failed", ["error" => $e->getMessage()]);
            return response()->json(["message" => "Registration failed. Please try again."], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
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
        } catch (\Throwable $e) {
            Log::error("GateLog sendOtp failed", ["error" => $e->getMessage()]);
            return response()->json(
                ["message" => "Unable to send OTP right now. Please try again."],
                500,
            );
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
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
        } catch (\Throwable $e) {
            Log::error("GateLog verifyOtp failed", ["error" => $e->getMessage()]);
            return response()->json(
                ["message" => "OTP verification failed. Please try again."],
                500,
            );
        }
    }

    public function login(Request $request)
    {
        try {
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
                "user" => [
                    "id" => $user->id,
                    "school_id" => $user->school_id,
                    "name" => $user->name,
                    "email" => $user->email,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error("GateLog login failed", ["error" => $e->getMessage()]);
            return response()->json(["message" => "Login failed. Please try again."], 500);
        }
    }

    public function sendPasswordResetOtp(Request $request)
    {
        try {
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

            $code = (string) random_int(100000, 999999);
            Redis::setex(
                $this->passwordResetOtpKey($email),
                self::OTP_TTL_SECONDS,
                Hash::make($code),
            );
            Redis::del($this->passwordResetOtpAttemptsKey($email));
            Redis::del($this->passwordResetVerifiedKey($email));

            Mail::to($email)->send(new GateLogOtpMail($code));

            return response()->json(["message" => "Password reset OTP sent."]);
        } catch (\Throwable $e) {
            Log::error("GateLog sendPasswordResetOtp failed", ["error" => $e->getMessage()]);
            return response()->json(
                ["message" => "Unable to send password reset OTP right now."],
                500,
            );
        }
    }

    public function verifyPasswordResetOtp(Request $request)
    {
        try {
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

            $otpHash = Redis::get($this->passwordResetOtpKey($email));
            if (!$otpHash) {
                return response()->json(["message" => "No active OTP found."], 422);
            }

            $attempts = (int) (Redis::get($this->passwordResetOtpAttemptsKey($email)) ?? 0);
            if ($attempts >= 5) {
                return response()->json(["message" => "OTP attempts exceeded."], 429);
            }

            if (!Hash::check($data["otp"], $otpHash)) {
                $attempts = Redis::incr($this->passwordResetOtpAttemptsKey($email));
                if ($attempts === 1) {
                    Redis::expire(
                        $this->passwordResetOtpAttemptsKey($email),
                        self::OTP_TTL_SECONDS,
                    );
                }
                return response()->json(["message" => "Invalid OTP."], 422);
            }

            Redis::del($this->passwordResetOtpKey($email));
            Redis::del($this->passwordResetOtpAttemptsKey($email));

            $resetToken = bin2hex(random_bytes(32));
            Redis::setex(
                $this->passwordResetVerifiedKey($email),
                self::RESET_TOKEN_TTL_SECONDS,
                $resetToken,
            );

            return response()->json([
                "message" => "OTP verified.",
                "reset_token" => $resetToken,
            ]);
        } catch (\Throwable $e) {
            Log::error("GateLog verifyPasswordResetOtp failed", ["error" => $e->getMessage()]);
            return response()->json(
                ["message" => "OTP verification failed. Please try again."],
                500,
            );
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $data = $request->validate([
                "email" => ["required", "email"],
                "reset_token" => ["required", "string"],
                "password" => ["required", "string", "min:8", "confirmed"],
            ]);

            $email = strtolower($data["email"]);
            $user = GatelogUser::query()
                ->whereRaw("LOWER(email) = ?", [$email])
                ->first();

            if (!$user) {
                return response()->json(["message" => "User not found."], 404);
            }

            $storedToken = (string) Redis::get($this->passwordResetVerifiedKey($email));
            if ($storedToken === "" || !hash_equals($storedToken, $data["reset_token"])) {
                return response()->json(
                    ["message" => "Password reset session is invalid or expired."],
                    422,
                );
            }

            $user->password = $data["password"];
            $user->save();

            Redis::del($this->passwordResetVerifiedKey($email));

            return response()->json(["message" => "Password updated successfully."]);
        } catch (\Throwable $e) {
            Log::error("GateLog resetPassword failed", ["error" => $e->getMessage()]);
            return response()->json(["message" => "Password reset failed. Please try again."], 500);
        }
    }

    private function createGatelogToken(GatelogUser $user, string $name): string
    {
        $plainTextToken = bin2hex(random_bytes(40));

        $token = new PersonalAccessToken();
        $token->forceFill([
            "name" => $name,
            "token" => hash("sha256", $plainTextToken),
            "abilities" => ["*"],
        ]);
        $token->tokenable()->associate($user);
        $token->save();

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

    private function passwordResetOtpKey(string $email): string
    {
        return "gatelog:password_reset:otp:" . strtolower($email);
    }

    private function passwordResetOtpAttemptsKey(string $email): string
    {
        return "gatelog:password_reset:otp_attempts:" . strtolower($email);
    }

    private function passwordResetVerifiedKey(string $email): string
    {
        return "gatelog:password_reset:verified:" . strtolower($email);
    }

    private const OTP_TTL_SECONDS = 1800;
    private const RESET_TOKEN_TTL_SECONDS = 1800;
}
