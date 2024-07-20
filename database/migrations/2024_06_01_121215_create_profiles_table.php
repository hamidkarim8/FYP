<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Profile;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fullname')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('avatar')->nullable();
            $table->json('social_media')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Profile::create(['user_id' => 1]);//admin

    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}

