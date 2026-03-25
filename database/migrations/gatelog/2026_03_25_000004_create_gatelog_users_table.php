<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run this migration on the gatelog connection only.
     */
    protected $connection = "pgsql_gatelog";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create("users", function (Blueprint $table) {
            $table->id();
            $table->foreignId("school_id")->after("id")->constrained("schools")->cascadeOnDelete();
            $table->string("name");
            $table->string("email");
            $table->timestamp("email_verified_at")->nullable();
            $table->string("password");
            $table->rememberToken();
            $table->timestamps();

            $table->unique(["school_id", "email"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists("users");
    }
};
