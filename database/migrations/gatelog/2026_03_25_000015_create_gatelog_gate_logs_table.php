<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = "pgsql_gatelog";

    public function up(): void
    {
        Schema::connection($this->connection)->create("gate_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("school_id")->constrained("schools")->cascadeOnDelete();
            $table->foreignId("student_id")->constrained("students")->cascadeOnDelete();
            $table->string("direction", 10); // in/out
            $table->timestamp("logged_at");
            $table->string("gate_name")->nullable();
            $table->string("source_ref")->nullable();
            $table->boolean("push_notified")->default(false);
            $table->timestamp("push_notified_at")->nullable();
            $table->timestamps();

            $table->index(["school_id", "student_id", "logged_at"]);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists("gate_logs");
    }
};
