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
        Schema::table('people', function (Blueprint $table) {
           $table->integer('auditorium_id')->constrained('auditoriums');
           $table->boolean('is_active');
        });
        Schema::table('people_positions', function (Blueprint $table) {
            $table->date('start_date');
            $table->date('end_date');
            $table->dropColumn('is_active');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('auditorium_id');
            $table->dropColumn('is_active');
        });
        Schema::table('people_positions', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->boolean('is_active');
        });
    }
};
