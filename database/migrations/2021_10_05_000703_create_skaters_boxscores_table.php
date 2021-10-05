<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkatersBoxscoresTable extends Migration
{
    public function up(): void
    {
        Schema::create('skaters_boxscores', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id');
            $table->time('toi');
            $table->smallInteger('goals');
            $table->smallInteger('assists');
            $table->smallInteger('shots');
            $table->smallInteger('hits');
            $table->smallInteger('pp_goals');
            $table->smallInteger('pp_assists');
            $table->smallInteger('pp_points');
            $table->smallInteger('pim');
            $table->smallInteger('fo_wins');
            $table->smallInteger('fo_taken');
            $table->smallInteger('takeaways');
            $table->smallInteger('giveaways');
            $table->smallInteger('sh_goals');
            $table->smallInteger('sh_assists');
            $table->smallInteger('sh_points');
            $table->smallInteger('blocked_shots');
            $table->smallInteger('plus_minus');
            $table->time('ev_toi');
            $table->time('pp_toi');
            $table->time('pk_toi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skaters_boxscores');
    }
}
