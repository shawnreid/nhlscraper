<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalieStatsAlltimeTable extends Migration
{
    public function up(): void
    {
        Schema::create('goalie_stats_alltime', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players');
            $table->tinyInteger('game_type_id');
            $table->integer('games_played')->default(0);
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
        Schema::dropIfExists('goalie_stats_alltime');
    }
}
