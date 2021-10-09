<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    public function up(): void
    {
        Schema::create('years', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->integer('year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('years');
    }
}
