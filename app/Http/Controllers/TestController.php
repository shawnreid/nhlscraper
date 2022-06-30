<?php

namespace App\Http\Controllers;

use App\Models\Games\GoalieStats;

class TestController extends Controller
{
    public function index()
    {
        $stats = GoalieStats::factory()->count(10)->create();
        dd($stats->avg('pp_svp'));
    }
}
