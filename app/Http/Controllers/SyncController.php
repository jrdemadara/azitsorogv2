<?php

namespace App\Http\Controllers;

use App\Models\LigaBarangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SyncController extends Controller
{
    public function checkSync()
    {
        $pendingCount = LigaBarangay::where("is_downloaded", false)->count();
        $totalCount = LigaBarangay::count();

        return response()->json([
            "pending_count" => $pendingCount,
            "total_count" => $totalCount,
        ]);
    }

    public function syncData(Request $request)
    {
        $request->validate([
            "limit" => "required|integer",
            "last_id" => "nullable|integer",
        ]);

        $limit = $request->input("limit");
        $lastId = $request->input("last_id", 0);

        // Use id > last_id for cursor-based pagination
        $profiles = LigaBarangay::where("is_downloaded", false)
            ->where("id", ">", $lastId)
            ->orderBy("id", "asc")
            ->limit($limit)
            ->get();

        $data = $profiles->map(function ($profile) {
            return [
                "id" => $profile->id,
                "lastname" => $profile->lastname,
                "firstname" => $profile->firstname,
                "middlename" => $profile->middlename,
                "extension" => $profile->extension,
                "home_address" => $profile->home_address,
                "gender" => $profile->gender,
                "birthdate" => $profile->birthdate,
                "region" => $profile->region,
                "province" => $profile->province,
                "city" => $profile->city,
                "barangay" => $profile->barangay,
                "year_elected" => $profile->year_elected,
                "term" => $profile->term,
                "photo" => $this->getBase64FromStorage("profiles/" . $profile->photo),
                "signature" => $this->getBase64FromStorage("signatures/" . $profile->signature),
            ];
        });

        return response()->json([
            "data" => $data,
            "next_cursor" => $profiles->last()?->id ?? null,
        ]);
    }

    public function markDownloaded(Request $request)
    {
        $request->validate([
            "ids" => "required|array",
            "ids.*" => "integer",
        ]);

        LigaBarangay::whereIn("id", $request->ids)->update(["is_downloaded" => true]);

        return response()->json(["success" => true]);
    }

    private function getBase64FromStorage(?string $path): ?string
    {
        if (!$path || !Storage::disk("external_storage")->exists($path)) {
            return null;
        }

        $fileContents = Storage::disk("external_storage")->get($path);
        $mime = Storage::disk("external_storage")->mimeType($path);

        return "data:" . $mime . ";base64," . base64_encode($fileContents);
    }
}
