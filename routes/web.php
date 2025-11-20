<?php

use App\Http\Controllers\SecureFileController;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth"])->group(function () {
    Route::get("/secure-file/{type}/{filename}", [SecureFileController::class, "show"])->name(
        "secure.file",
    );
});

// PDF download route for Filament admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get("/invoices/{id}/download-pdf", [\App\Http\Controllers\InvoicePdfController::class, "downloadPdf"])
        ->name("filament.admin.resources.draft-invoices.download-pdf");
});

// SPA catch-all route: must be last to allow other routes to take precedence
Route::get("/{any}", fn() => view("welcome"))->where("any", ".*");
