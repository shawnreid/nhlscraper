<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesSkaterStatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('games_skater_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->tinyInteger('game_type_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players');
            $table->smallInteger('goals')->default(0);
            $table->smallInteger('assists')->default(0);
            $table->smallInteger('points')->default(0);
            $table->smallInteger('shots')->default(0);
            $table->smallInteger('hits')->default(0);
            $table->smallInteger('pp_goals')->default(0);
            $table->smallInteger('pp_assists')->default(0);
            $table->smallInteger('pp_points')->default(0);
            $table->smallInteger('pim')->default(0);
            $table->smallInteger('fo_wins')->default(0);
            $table->smallInteger('fo_taken')->default(0);
            $table->smallInteger('takeaways')->default(0);
            $table->smallInteger('giveaways')->default(0);
            $table->smallInteger('sh_goals')->default(0);
            $table->smallInteger('sh_assists')->default(0);
            $table->smallInteger('sh_points')->default(0);
            $table->smallInteger('blocked_shots')->default(0);
            $table->smallInteger('plus_minus')->default(0);
            $table->string('toi')->default(0);
            $table->string('ev_toi')->default(0);
            $table->string('pp_toi')->default(0);
            $table->string('sh_toi')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games_skater_stats');
    }
}
