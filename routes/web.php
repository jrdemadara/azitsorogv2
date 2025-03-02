<?php

use App\Http\Controllers\SecureFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/secure-file/{type}/{filename}', [SecureFileController::class, 'show'])
        ->name('secure.file');
});
