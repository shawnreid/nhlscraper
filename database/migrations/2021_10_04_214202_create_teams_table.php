<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
}
