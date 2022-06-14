<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonsTable extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->integer('season');
            $table->tinyInteger('imported');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
}
