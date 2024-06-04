<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'normal_user']);
            $table->rememberToken();
            $table->timestamps();
        });
        User::create(['name' => 'admin','email' => 'admin@gmail.com','password' => Hash::make('123456'),'role'=>'admin','created_at' => now(),]);//admin
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

