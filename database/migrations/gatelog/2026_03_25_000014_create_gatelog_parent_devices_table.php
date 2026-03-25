<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'pgsql_gatelog';

    public function up(): void
    {
        Schema::connection($this->connection)->create('parent_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('platform', 20)->nullable();
            $table->text('push_token');
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['school_id', 'user_id', 'push_token']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('parent_devices');
    }
};
