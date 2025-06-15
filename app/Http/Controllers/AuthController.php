<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (!Auth::attempt($request->only("email", "password"))) {
            return response()->json(
                [
                    "message" => "Invalid credentials",
                ],
                401
            );
        }

        $user = Auth::user();
        $token = $user->createToken("desktop_app_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
        ]);
    }
}
