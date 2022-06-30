<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePlayByPlayTable extends Migration
{
    public function up(): void
    {
        Schema::create('game_play_by_play', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->tinyInteger('game_type_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->string('event')->nullable();
            $table->string('code')->nullable();
            $table->text('desc_full')->nullable();
            $table->string('desc_short')->nullable();
            $table->tinyInteger('period')->nullable();
            $table->string('time')->nullable();
            $table->string('time_left')->nullable();
            $table->unsignedBigInteger('player1_id')->nullable();
            $table->unsignedBigInteger('player2_id')->nullable();
            $table->string('player1_type')->nullable();
            $table->string('player2_type')->nullable();
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->integer('x_coord')->nullable();
            $table->integer('y_coord')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_play_by_play');
    }
}
