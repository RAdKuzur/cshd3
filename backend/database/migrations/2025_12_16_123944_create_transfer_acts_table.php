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
        Schema::create('transfer_acts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->nullable()->constrained('people_positions');
            $table->foreignId('to')->nullable()->constrained('people_positions');
            $table->date('date');
            $table->integer('confirmed')->nullable(false);
            $table->integer('type')->nullable(false);
            $table->timestamps();
        });

        Schema::create('transfer_act_things', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_act_id')->constrained('transfer_acts', 'id');
            $table->foreignId('thing_id')->constrained('things');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_act_things');
        Schema::dropIfExists('transfer_acts');
    }
};
