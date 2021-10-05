<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->integer('id')->unique();
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

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
