<?php

namespace App\Http\Middleware;

use App\Models\Gatelog\GatelogUser;
use App\Models\Gatelog\PersonalAccessToken;
use Closure;
use Illuminate\Http\Request;

class AuthenticateGatelogToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || !$accessToken->tokenable instanceof GatelogUser) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->setUserResolver(function () use ($accessToken) {
            return $accessToken->tokenable;
        });

        return $next($request);
    }
}
