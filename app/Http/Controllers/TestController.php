<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\GameService;

class TestController extends Controller
{
    public function index(GameService $game): void
    {
        $schedule = Schedule::search(2019020001);
        $game->fetch($schedule);
    }
}
