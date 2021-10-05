<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoaliesBoxscoresTable extends Migration
{
    public function up(): void
    {
        Schema::create('goalies_boxscores', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id');
            $table->time('toi');
            $table->smallInteger('goals');
            $table->smallInteger('assists');
            $table->smallInteger('pim');
            $table->smallInteger('shots');
            $table->smallInteger('saves');
            $table->smallInteger('pp_saves');
            $table->smallInteger('sh_saves');
            $table->smallInteger('ev_saves');
            $table->smallInteger('pp_shots');
            $table->smallInteger('sh_shots');
            $table->smallInteger('ev_shots');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goalies_boxscores');
    }
}
