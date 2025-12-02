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
        Schema::create('things', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial_number')->nullable();
            $table->integer('inv_number')->nullable();
            $table->date('operation_date')->nullable();
            $table->integer('thing_type_id');
            $table->foreignId('thing_parent_id')
                ->nullable()
                ->constrained('things')
                ->nullOnDelete();
            $table->integer('condition')->nullable(false);
            $table->float('price')->nullable(false);
            $table->string('comment')->nullable();
            $table->timestamps();
        });
        Schema::create('thing_auditoriums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thing_id')->constrained('things');
            $table->foreignId('auditorium_id')->constrained('auditoriums');
            $table->date('start_date');
            $table->date('end_date');
        });
        Schema::create('thing_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thing_id')->constrained('things');
            $table->foreignId('people_id')->constrained('people');
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thing_responsibilities');
        Schema::dropIfExists('thing_auditoriums');
        Schema::dropIfExists('things');
    }
};
