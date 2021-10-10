<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            YearsSeeder::class,
            GamesTypesSeeder::class,
            PositionsSeeder::class,
            TeamsSeeder::class
        ]);
    }
}
