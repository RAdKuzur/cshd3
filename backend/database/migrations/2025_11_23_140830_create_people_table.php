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
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('inn')->nullable();
            $table->string('ogrn')->nullable();
            $table->timestamps();
        });
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('phone_number');
            $table->string('icon_link')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('organization_id')->constrained('organizations');
            $table->integer('user_id')->constrained('users');
            $table->text('about')->nullable();
            $table->timestamps();
        });
        Schema::create('people_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('people_id')->constrained('people', 'people_id');
            $table->integer('position_id')->constrained('positions');
            $table->integer('branch_id')->constrained('branches');
            $table->boolean('is_active');
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
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('branches');
    }
};
