<?php

use App\Http\Controllers\SecureFileController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    abort(403);
});

Route::middleware(["auth"])->group(function () {
    Route::get("/secure-file/{type}/{filename}", [SecureFileController::class, "show"])->name(
        "secure.file"
    );
});
