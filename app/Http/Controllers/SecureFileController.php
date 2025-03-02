<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SecureFileController extends Controller
{
    public function show($type, $filename): BinaryFileResponse
    {
        // Define allowed types and their corresponding directories
        $allowedTypes = [
            'invoice'      => 'private/invoices',
            'deposit-slip' => 'private/deposit-slip',
        ];

        // Validate if the type exists
        if (! array_key_exists($type, $allowedTypes)) {
            abort(403, 'Unauthorized access');
        }

        // Extract only the file name (in case the filename is stored as "invoice/name.jpg")
        $filename = basename($filename);

        // Get the correct file path
        $path = storage_path("app/{$allowedTypes[$type]}/{$filename}");

        // Check if file exists
        if (! file_exists($path)) {
            abort(404);
        }

        // Serve the file securely
        return response()->file($path, ['Cache-Control' => 'no-store, no-cache, must-revalidate']);
    }
}
