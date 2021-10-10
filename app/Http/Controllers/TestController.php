<?php

namespace App\Http\Controllers;

use App\Models\Games\Games;
use App\Services\Game\GameService;

class TestController extends Controller
{
    public function index(GameService $game): void
    {
        #dd(phpinfo());
        $x = 2019020001;
        $end = $x + 50;
        while ($x <= $end) {
            $games = Games::search($x);
            $game->fetch($games);
            $x++;
        }
    }
}
