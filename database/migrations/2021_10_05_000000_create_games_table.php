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
            $table->unsignedBigInteger('home_id')->nullable();
            $table->foreign('home_id')->references('id')->on('teams');
            $table->unsignedBigInteger('away_id')->nullable();
            $table->foreign('away_id')->references('id')->on('teams');
            $table->integer('status');
            $table->tinyInteger('imported')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
