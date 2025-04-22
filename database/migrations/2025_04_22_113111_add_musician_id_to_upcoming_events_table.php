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
        Schema::table('upcoming_events', function (Blueprint $table) {
            $table->unsignedBigInteger('musician_id')->after('id');
            $table->foreign('musician_id')->references('id')->on('musicians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('upcoming_events', function (Blueprint $table) {
            $table->dropForeign(['musician_id']);
            $table->dropColumn('musician_id');
        });
    }
};
