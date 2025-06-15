<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthCheckController extends Controller
{
    public function healthCheck(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                "status" => "ok",
            ]);
        }

        return response()->json(["status" => "unauthorized"], 401);
    }
}
