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
                'abbreviation' => 'C',
                'name'         => 'Center'
            ],
            [
                'abbreviation' => 'LW',
                'name'         => 'Left Wing'
            ],
            [
                'abbreviation' => 'RW',
                'name'         => 'Right Wing'
            ],
            [
                'abbreviation' => 'LD',
                'name'         => 'Left Defensemen'
            ],
            [
                'abbreviation' => 'RD',
                'name'         => 'Right Defensemen'
            ],
            [
                'abbreviation' => 'G',
                'name'         => 'Goalie'
            ],
        ]);
    }
}
