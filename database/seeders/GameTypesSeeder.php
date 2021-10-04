<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_types')->insert([
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
