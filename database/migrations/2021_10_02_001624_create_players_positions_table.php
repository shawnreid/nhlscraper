<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersPositionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('players_positions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('abbreviation', 2);
            $table->string('name', 16);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players_positions');
    }
}
