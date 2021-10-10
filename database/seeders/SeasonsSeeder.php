<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonsSeeder extends Seeder
{
    public function run()
    {
        $season = 1917;
        while ($season !== (now()->year + 1)) {
            DB::table('seasons')->insert([
                'id'     => $season.($season+1),
                'season' => $season
            ]);
            $season++;
        }
    }
}
