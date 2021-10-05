<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->smallInteger('primary_number');
            $table->date('date_of_birth');
            $table->string('birth_city');
            $table->string('birth_state_province');
            $table->string('birth_country');
            $table->string('nationality');
            $table->string('height');
            $table->smallInteger('weight');
            $table->tinyInteger('active');
            $table->string('shoots_catches', 1);
            $table->string('primary_position', 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
}
