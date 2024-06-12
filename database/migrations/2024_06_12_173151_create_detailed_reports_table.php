<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailed_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->enum('type', ['found', 'lost']);
            $table->unsignedBigInteger('category_id');
            $table->text('description')->nullable();
            $table->text('image_paths');
            $table->json('location');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone_number');
            $table->json('social_media')->nullable();
            $table->timestamp('reported_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailed_reports');
    }
};
