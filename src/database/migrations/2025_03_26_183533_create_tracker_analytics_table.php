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
        Schema::create('tracker_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracker_id')->unique()->constrained();
            $table->jsonb('daily_sixty_day_uptime')->nullable();
            $table->double('percentage_sixty_day_uptime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker_analytics');
    }
};
