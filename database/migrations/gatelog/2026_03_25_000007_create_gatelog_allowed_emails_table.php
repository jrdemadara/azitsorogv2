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
        Schema::connection($this->connection)->create("allowed_emails", function (
            Blueprint $table,
        ) {
            $table->id();
            $table->foreignId("school_id")->after("id")->constrained("schools")->cascadeOnDelete();
            $table->string("owner_name");
            $table->string("email");
            $table->boolean("is_used")->default(false);
            $table->timestamps();

            $table->unique(["school_id", "email"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists("allowed_emails");
    }
};
