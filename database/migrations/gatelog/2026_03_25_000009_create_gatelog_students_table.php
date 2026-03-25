<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run this migration on the gatelog connection only.
     */
    protected $connection = 'pgsql_gatelog';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('student_id_number');
            $table->string('full_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Student number can repeat across schools but must be unique within a school.
            $table->unique(['school_id', 'student_id_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('students');
    }
};
