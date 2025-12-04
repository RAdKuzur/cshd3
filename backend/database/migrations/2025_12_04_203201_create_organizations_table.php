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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('address')->nullable();
            $table->string('inn')->nullable();
            $table->string('ogrn')->nullable();
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table){
            $table->id();
            $table->string('name')->nullable(false);
            $table->foreignId('organization_id')->constrained('organizations');
            $table->string('address')->nullable();
            $table->timestamps();
        });

        Schema::create('auditoriums', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('number')->nullable(false);
            $table->integer('floor')->nullable(false);
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
        });
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->foreignId('organization_id')->constrained('organizations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
        Schema::dropIfExists('auditoriums');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('organizations');
    }
};
