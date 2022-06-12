<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonsGoalieStatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('seasons_goalie_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->tinyInteger('game_type_id');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players');
            $table->smallInteger('games_played')->default(0);
            $table->integer('toi')->default(0);
            $table->smallInteger('goals')->default(0);
            $table->smallInteger('assists')->default(0);
            $table->smallInteger('pim')->default(0);
            $table->smallInteger('saves')->default(0);
            $table->smallInteger('pp_saves')->default(0);
            $table->smallInteger('sh_saves')->default(0);
            $table->smallInteger('ev_saves')->default(0);
            $table->smallInteger('shots')->default(0);
            $table->smallInteger('pp_shots')->default(0);
            $table->smallInteger('sh_shots')->default(0);
            $table->smallInteger('ev_shots')->default(0);
            $table->decimal('svp', 6, 2)->default(0);
            $table->decimal('pp_svp', 6, 2)->default(0);
            $table->decimal('sh_svp', 6, 2)->default(0);
            $table->decimal('ev_svp', 6, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons_goalie_stats');
    }
}
