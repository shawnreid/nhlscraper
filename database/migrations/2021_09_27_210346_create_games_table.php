<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->integer('game_id')->unique();
            $table->integer('year_id');
            $table->date('date');
            $table->tinyInteger('game_type_id');
            $table->integer('home_id');
            $table->integer('away_id');
            $table->integer('home_score');
            $table->integer('away_score');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
