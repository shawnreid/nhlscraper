<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    public function up(): void
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id')->references('id')->on('years');
            $table->date('date');
            $table->tinyInteger('game_type_id');
            $table->integer('home_id');
            $table->integer('away_id');
            $table->integer('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
}
