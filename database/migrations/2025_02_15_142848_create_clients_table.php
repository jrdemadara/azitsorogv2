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
        Schema::connection('pgsql_main')->create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tin');
            $table->string('address');
            $table->string('terms');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_main')->dropIfExists('clients');

    }
};
