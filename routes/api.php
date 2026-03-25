<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GateLog\GateLogAuthController;
use App\Http\Controllers\GateLog\GateLogController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::post("/login", [AuthController::class, "login"]);
Route::post("/messages", [MessageController::class, "store"]);
Route::prefix("gatelog")->group(function () {
    Route::post("/auth/register", [GateLogAuthController::class, "register"]);
    Route::post("/auth/otp/send", [GateLogAuthController::class, "sendOtp"]);
    Route::post("/auth/otp/verify", [GateLogAuthController::class, "verifyOtp"]);
    Route::post("/auth/login", [GateLogAuthController::class, "login"]);
    Route::post("/ingest/logs", [GateLogController::class, "ingestGateLog"]);

    Route::middleware(["auth.gatelog"])->group(function () {
        Route::get("/students", [GateLogController::class, "linkedStudents"]);
        Route::post("/students/link", [GateLogController::class, "linkStudent"]);
        Route::post("/devices/register", [GateLogController::class, "registerDevice"]);
        Route::get("/logs/pull", [GateLogController::class, "pullLogs"]);
    });
});

Route::middleware(["auth:sanctum"])->group(function () {
    Route::get("/ping", [HealthCheckController::class, "healthCheck"]);
    Route::get("/check", [SyncController::class, "checkSync"]);
    Route::get("/sync", [SyncController::class, "syncData"]);
    Route::get("/mark-downloaded", [SyncController::class, "markDownloaded"]);
});
