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
        Schema::create('transfer_act_confirms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('people_position_id')->constrained('people_positions', 'id');
            $table->foreignId('transfer_act_id')->constrained('transfer_acts', 'id');
            $table->integer('status')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_act_confirms');
    }
};
