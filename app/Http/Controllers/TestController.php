<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Years;
use App\Services\BoxScoreService;
use App\Services\GameService;
use App\Services\ScheduleService;

class TestController extends Controller
{
    public function index(GameService $game): void
    {
        Schedule::all()->each(function(Schedule $schedule) use ($game): void {
            $game->fetch($schedule);
        });
    }
}
