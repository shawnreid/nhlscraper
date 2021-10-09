<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameGoalieBoxscoresTable extends Migration
{
    public function up(): void
    {
        Schema::create('game_goalie_boxscores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->foreign('schedule_id')->references('id')->on('schedule');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->time('toi')->default(0);
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
        Schema::dropIfExists('game_goalie_boxscores');
    }
}
