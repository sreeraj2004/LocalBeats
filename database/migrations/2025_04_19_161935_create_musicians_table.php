<?php
// database/migrations/YYYY_MM_DD_create_musicians_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusiciansTable extends Migration
{
    public function up()
    {
        Schema::create('musicians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('band_name');
            $table->string('genre');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('musicians');
    }
}
