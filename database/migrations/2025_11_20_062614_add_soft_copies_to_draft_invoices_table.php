<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql_main')->table('draft_invoices', function (Blueprint $table) {
            $table->json('soft_copies')->nullable()->after('printed_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_main')->table('draft_invoices', function (Blueprint $table) {
            $table->dropColumn('soft_copies');
        });
    }
};
