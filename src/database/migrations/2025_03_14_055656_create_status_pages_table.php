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
        Schema::create('status_pages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('team_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('url_slug')->nullable()->unique();
            $table->boolean('is_published')->default(0);
            $table->boolean('is_archived')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pages');
    }
};
