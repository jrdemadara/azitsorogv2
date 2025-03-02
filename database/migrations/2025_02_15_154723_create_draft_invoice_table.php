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
        Schema::connection('pgsql_main')->create('draft_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('si_number');
            $table->string('type');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->foreignId('client_id')->constrained('clients')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_main')->dropIfExists('draft_invoice');
    }
};
