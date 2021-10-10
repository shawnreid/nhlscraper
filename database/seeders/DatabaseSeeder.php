<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            YearsSeeder::class,
            TeamsSeeder::class,
            Games\TypesSeeder::class,
            Players\PositionsSeeder::class,
        ]);
    }
}
