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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('route')->nullable();
            $table->string('url')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('host')->nullable();
            $table->string('request_method')->nullable();
            $table->datetime('request_time')->nullable();
            $table->string('user_agent')->nullable();
            //$table->integer('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
