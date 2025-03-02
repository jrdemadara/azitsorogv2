<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('pgsql_main')->create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('deposit_slip');
            $table->foreignId('draft_invoice_id')->constrained('draft_invoices')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_main')->dropIfExists('sales_invoice');
    }
};
