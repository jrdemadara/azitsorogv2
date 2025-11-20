<?php

use App\Http\Controllers\AuthController;
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

Route::middleware(["auth:sanctum"])->group(function () {
    Route::get("/ping", [HealthCheckController::class, "healthCheck"]);
    Route::get("/check", [SyncController::class, "checkSync"]);
    Route::get("/sync", [SyncController::class, "syncData"]);
    Route::get("/mark-downloaded", [SyncController::class, "markDownloaded"]);
});
