<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviation', 2);
            $table->string('name', 16);
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
