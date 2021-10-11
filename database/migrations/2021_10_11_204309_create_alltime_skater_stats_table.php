<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlltimeSkaterStatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('alltime_skater_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players');
            $table->tinyInteger('game_type_id');
            $table->smallInteger('games_played')->default(0);
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
            $table->integer('toi')->default(0);
            $table->integer('ev_toi')->default(0);
            $table->integer('pp_toi')->default(0);
            $table->integer('sh_toi')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alltime_skater_stats');
    }
}
