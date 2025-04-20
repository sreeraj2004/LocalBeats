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
        Schema::table('upcoming_events', function (Blueprint $table) {
            $table->string('image')->after('id');
            $table->string('name')->after('image');
            $table->date('date')->after('name');
            $table->string('location')->after('date');
            $table->time('time')->after('location');
            $table->decimal('price', 8, 2)->after('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('upcoming_events', function (Blueprint $table) {
            $table->dropColumn(['image', 'name', 'date', 'location', 'time', 'price']);
        });
    }
}; 