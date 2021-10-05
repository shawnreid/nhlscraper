<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    public function up(): void
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('year_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('years');
    }
}
