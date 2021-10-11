<?php

namespace App\Http\Controllers;

use App\Jobs\FetchGameJob;
use App\Models\Games\Games;
use App\Models\Seasons;
use App\Services\Game\GameService;
use App\Services\Game\ScheduleService;

class TestController extends Controller
{
    public function index(GameService $game, ScheduleService $schedule): void
    {
        #$schedule->fetch(Seasons::search(2018));
        #foreach (Games::all() as $g) {
            #$game->fetch($g);
        #    FetchGameJob::dispatch($g);
        #}
        
        #$x = 2018020001;
        #$end = $x;
        #while ($x <= $end) {
        #    $games = Games::search($x);
        #    $game->fetch($games);
        #    $x++;
        #}
        
    }
}
