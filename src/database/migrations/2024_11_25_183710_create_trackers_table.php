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
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tracker_type_id')->default(1)->constrained();
            $table->text('url');
            $table->text('descr')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->integer('port')->nullable();
            $table->integer('retries')->default(3);
            $table->string('check_frequency')->default('every_30s');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackers');
    }
};
