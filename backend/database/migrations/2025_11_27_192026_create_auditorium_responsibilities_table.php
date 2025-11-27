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
        Schema::create('auditorium_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->integer('auditorium_id')->constrained('auditoriums');
            $table->integer('people_id')->constrained('people');
            $table->date('start_date');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorium_responsibilities');
    }
};
