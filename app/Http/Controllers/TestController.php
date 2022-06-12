<?php

namespace App\Http\Controllers;

use App\Jobs\GameJob;
use App\Models\Games\Games;
use App\Models\Games\SkaterStats;
use App\Models\Seasons\Seasons;
use App\Services\Game\GameService;
use App\Services\Game\ScheduleService;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index(): void
    {

    }
}
