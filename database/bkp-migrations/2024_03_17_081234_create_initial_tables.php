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
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemName');
            $table->text('description');
            $table->string('location');
            $table->date('dateLost');
            $table->boolean('isResolved')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('found_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemName');
            $table->text('description');
            $table->string('location');
            $table->date('dateFound');
            $table->boolean('isResolved')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->text('feedbackMessage');
            $table->date('dateSubmitted');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('reportType');
            $table->text('reportMessage');
            $table->date('dateSubmitted');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lost_item_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('found_item_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('notificationMessage');
            $table->date('dateSent');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lost_items');
        Schema::dropIfExists('found_items');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('notifications');    }
};
