<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('pgsql_main')->table('invoice_items', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->after('id')
                ->constrained('products')
                ->nullOnDelete()
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::connection('pgsql_main')->table('invoice_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
        });
    }
};
