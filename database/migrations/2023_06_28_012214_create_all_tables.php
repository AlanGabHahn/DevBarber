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
        //tabelas relacionadas a usuários
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('default.png');
        });
        Schema::create('users_favorites', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('barber_id');
        });
        Schema::create('users_appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('barber_id');
            $table->datetime('appointment_date');
        });

        //tabelas relacionadas a barbeiros
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('avatar')->default('default.png');
            $table->float('stars')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitute')->nullable();
        });
        Schema::create('barbers_photo', function (Blueprint $table) {
            $table->id();
            $table->integer('barber_id');
            $table->string('image');
        });
        Schema::create('barbers_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('barber_id');
            $table->float('rate');
        });
        Schema::create('barbers_service', function (Blueprint $table) {
            $table->id();
            $table->integer('barber_id');
            $table->string('name');
            $table->float('price');
        });
        Schema::create('barbers_testimonials', function (Blueprint $table) {
            $table->id();
            $table->integer('barber_id');
            $table->string('name');
            $table->float('rate');
            $table->string('body');
        });
        Schema::create('barbers_availability', function (Blueprint $table) {
            $table->id();
            $table->integer('barber_id');
            $table->integer('weekday');
            $table->text('hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_favorites');
        Schema::dropIfExists('users_appointments');
        Schema::dropIfExists('barbers');
        Schema::dropIfExists('barbers_photo');
        Schema::dropIfExists('barbers_reviews');
        Schema::dropIfExists('barbers_service');
        Schema::dropIfExists('barbers_testimonials');
        Schema::dropIfExists('barbers_availability');
    }
};
