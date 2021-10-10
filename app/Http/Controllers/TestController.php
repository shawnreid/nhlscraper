<?php

namespace App\Http\Controllers;

use App\Models\Games\Games;
use App\Services\Game\GameService;

class TestController extends Controller
{
    public function index(GameService $game): void
    {
        #dd(phpinfo());
        #$games = Games::search(2019020001);
        #$game->fetch($games);
    }
}
