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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->timestamps();
        });
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable(false);
            $table->string('surname')->nullable(false);
            $table->string('patronymic')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('icon_link')->nullable();
            $table->date('birthdate')->nullable();
            $table->foreignId('organization_id')->constrained('organizations');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('auditorium_id')->constrained('auditoriums');
            $table->boolean('is_active')->nullable(false);
            $table->text('about')->nullable();
            $table->timestamps();
        });

        Schema::create('people_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('people_id')->constrained('people');
            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('branch_id')->constrained('branches');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_positions');
        Schema::dropIfExists('people');
        Schema::dropIfExists('positions');
    }
};
