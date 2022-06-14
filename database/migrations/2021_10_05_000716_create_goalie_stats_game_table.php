<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalieStatsGameTable extends Migration
{
    public function up(): void
    {
        Schema::create('goalie_stats_game', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->tinyInteger('game_type_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->integer('toi')->default(0);
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('pim')->default(0);
            $table->integer('saves')->default(0);
            $table->integer('pp_saves')->default(0);
            $table->integer('sh_saves')->default(0);
            $table->integer('ev_saves')->default(0);
            $table->integer('shots')->default(0);
            $table->integer('pp_shots')->default(0);
            $table->integer('sh_shots')->default(0);
            $table->integer('ev_shots')->default(0);
            $table->decimal('svp', 6, 2)->default(0);
            $table->decimal('pp_svp', 6, 2)->default(0);
            $table->decimal('sh_svp', 6, 2)->default(0);
            $table->decimal('ev_svp', 6, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goalie_stats_game');
    }
}
