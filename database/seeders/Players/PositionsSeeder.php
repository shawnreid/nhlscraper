<?php

namespace Database\Seeders\Players;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('players_positions')->insert([
            [
                'id'           => 1,
                'abbreviation' => 'C',
                'name'         => 'Center'
            ],
            [
                'id'           => 2,
                'abbreviation' => 'LW',
                'name'         => 'Left Wing'
            ],
            [
                'id'           => 3,
                'abbreviation' => 'RW',
                'name'         => 'Right Wing'
            ],
            [
                'id'           => 4,
                'abbreviation' => 'LD',
                'name'         => 'Left Defensemen'
            ],

            [
                'id'           => 5,
                'abbreviation' => 'RD',
                'name'         => 'Right Defensemen'
            ],
            [
                'id'           => 6,
                'abbreviation' => 'D',
                'name'         => 'Defensemen'
            ],
            [
                'id'           => 7,
                'abbreviation' => 'G',
                'name'         => 'Goalie'
            ],
        ]);
    }
}
