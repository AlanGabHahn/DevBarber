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

        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('avatar')->default('default.png');
            $table->float('stars')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_tables');
    }
};
