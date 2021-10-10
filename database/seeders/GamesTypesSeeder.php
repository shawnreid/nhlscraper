<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('games_types')->insert([
            [
                'id'   => 1,
                'name' => 'Pre Season'
            ],
            [
                'id'   => 2,
                'name' => 'Regular Season'
            ],
            [
                'id'   => 3,
                'name' => 'Playoffs'
            ]
        ]);
    }
}
