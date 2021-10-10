<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->date('date');
            $table->tinyInteger('game_type_id');
            $table->integer('home_id');
            $table->integer('away_id');
            $table->integer('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
