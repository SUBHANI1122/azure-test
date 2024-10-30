<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('type');
            $table->integer('age');
            $table->rememberToken();
            $table->timestamps();
        });
        // Insert default admin user
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('12345678'),
            'type' => 'admin',
            'age' => 22,
        ]);

        \App\Models\User::create([
            'name' => 'Dr Afraz',
            'email' => 'afraz@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'doctor',
            'age' => 22,
        ]);

        \App\Models\User::create([
            'name' => 'Dr Ayesha',
            'email' => 'ayesha@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'doctor',
            'age' => 22,
        ]);

        \App\Models\User::create([
            'name' => 'Receptionist',
            'email' => 'reception@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'receptionist',
            'age' => 22,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
