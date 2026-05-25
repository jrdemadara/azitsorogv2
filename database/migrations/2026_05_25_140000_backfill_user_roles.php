<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('users')
            ->whereNull('role')
            ->update(['role' => User::ROLE_ADMIN]);
    }

    public function down(): void
    {
        // No-op: role backfill is intentionally irreversible.
    }
};
