<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'pgsql_gatelog';

    public function up(): void
    {
        Schema::connection($this->connection)->create('student_email_authorizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('email');
            $table->timestamps();

            $table->unique(['school_id', 'student_id', 'email']);
            $table->index(['school_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('student_email_authorizations');
    }
};
