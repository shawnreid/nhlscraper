<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
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
