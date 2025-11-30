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
        Schema::create('departments', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->integer('organization_id')->constrained('organizations');
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('auditoriums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->integer('floor');
            $table->integer('department_id')->constrained('departments');
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('inn')->nullable();
            $table->string('ogrn')->nullable();
            $table->timestamps();
        });
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('organization_id')->constrained('organizations');
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
            $table->integer('auditorium_id')->constrained('auditoriums');
            $table->boolean('is_active');
            $table->text('about')->nullable();
            $table->timestamps();
        });
        Schema::create('people_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('people_id')->constrained('people', 'people_id');
            $table->integer('position_id')->constrained('positions');
            $table->integer('branch_id')->constrained('branches');
            $table->date('start_date');
            $table->date('end_date');
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

        Schema::dropIfExists('auditoriums');
        Schema::dropIfExists('departments');
    }
};
