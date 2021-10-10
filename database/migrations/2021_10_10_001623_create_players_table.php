<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->smallInteger('primary_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('birth_state_province')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('nationality')->nullable();
            $table->integer('age')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('shoots_catches', 1)->nullable();
            $table->string('primary_position', 2)->nullable();
            $table->tinyInteger('alternate_captain')->default(0);
            $table->tinyInteger('captain')->default(0);
            $table->tinyInteger('rookie')->default(0);
            $table->tinyInteger('roster_status')->default(0);
            $table->tinyInteger('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
}
