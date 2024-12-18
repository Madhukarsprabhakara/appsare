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
        Schema::create('tracker_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('tracker_id')->constrained();
            //$table->foreignId('tracker_event_id')->constrained();
            $table->integer('number_notifications_sent')->nullable();
            $table->foreignId('notification_type_id')->constrained();
            $table->timestamp('acknowledged')->nullable();
            $table->timestamp('resolved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker_notifications');
    }
};
