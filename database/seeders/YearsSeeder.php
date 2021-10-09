<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearsSeeder extends Seeder
{
    public function run()
    {
        $year  = 1917;
        while ($year !== (now()->year + 1)) {
            DB::table('years')->insert([
                'id'   => $year.($year+1),
                'year' => $year
            ]);
            $year++;
        }
    }
}
