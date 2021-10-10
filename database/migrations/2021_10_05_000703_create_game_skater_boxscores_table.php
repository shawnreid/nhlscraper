<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameSkaterBoxscoresTable extends Migration
{
    public function up(): void
    {
        Schema::create('game_skater_boxscores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
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
            $table->time('toi')->default(0);
            $table->time('ev_toi')->default(0);
            $table->time('pp_toi')->default(0);
            $table->time('sh_toi')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_skater_boxscores');
    }
}
