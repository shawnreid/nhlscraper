<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamStatsGameTable extends Migration
{
    public function up(): void
    {
        Schema::create('team_stats_game', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->tinyInteger('game_type_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('points')->default(0);
            $table->integer('shots')->default(0);
            $table->integer('hits')->default(0);
            $table->integer('pp_goals')->default(0);
            $table->integer('pp_assists')->default(0);
            $table->integer('pp_points')->default(0);
            $table->integer('pim')->default(0);
            $table->integer('fo_wins')->default(0);
            $table->integer('fo_taken')->default(0);
            $table->integer('takeaways')->default(0);
            $table->integer('giveaways')->default(0);
            $table->integer('sh_goals')->default(0);
            $table->integer('sh_assists')->default(0);
            $table->integer('sh_points')->default(0);
            $table->integer('blocked_shots')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_stats_game');
    }
}
