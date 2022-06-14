<?php

namespace App\Http\Controllers;

use App\Models\Games\Games;
use App\Services\Game\GameService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        $game = Games::find(2016020001);
        (new GameService)->handle($game);
    }
}
