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
            $table->string('name')->nullable(false);
            $table->string('serial_number')->nullable();
            $table->string('inv_number')->nullable();
            $table->date('operation_date')->nullable();
            $table->integer('thing_type_id')->nullable(false);
            $table->foreignId('thing_parent_id')
                ->nullable()
                ->constrained('things')
                ->nullOnDelete();
            $table->integer('condition')->nullable();
            $table->integer('balance')->nullable();
            $table->float('price')->nullable()->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
        });
        Schema::create('thing_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thing_id')->constrained('things');
            $table->foreignId('people_id')->constrained('people');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thing_responsibilities');
        Schema::dropIfExists('things');
    }
};
