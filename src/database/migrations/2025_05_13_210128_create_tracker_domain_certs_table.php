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
        Schema::create('tracker_domain_certs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracker_id')->constrained()->cascadeOnDelete();
            $table->string('domain_name')->nullable();
            $table->timestamp('cert_expires_at')->nullable();
            $table->timestamp('domain_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker_domain_certs');
    }
};
