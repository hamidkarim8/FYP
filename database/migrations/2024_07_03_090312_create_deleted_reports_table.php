<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedReportsTable extends Migration
{
    public function up()
    {
        Schema::create('deleted_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('report_id');
            $table->enum('deleted_type', ['duplicate', 'irrelevant', 'malicious', 'fraudulent']);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deleted_reports');
    }
}
