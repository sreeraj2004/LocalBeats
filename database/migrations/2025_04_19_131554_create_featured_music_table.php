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
        Schema::create('featured_music', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('artist_name');
            $table->string('genre');
            $table->decimal('ratings', 3, 1);
            $table->string('song_path');
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
        Schema::dropIfExists('featured_music');
    }
};
