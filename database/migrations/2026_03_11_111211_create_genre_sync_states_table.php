<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genre_sync_states', function (Blueprint $table) {
            $table->id();
            $table->integer('genre_id')->unique();
            $table->string('name');
            $table->integer('current_index')->default(0);
            $table->integer('max_limit')->default(100);
            $table->boolean('is_paused')->default(false);
            $table->boolean('is_exhausted')->default(false);
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_sync_states');
    }
};
