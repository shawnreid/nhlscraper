<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Services\Game\StatsService;
use App\Services\Game\TimelineService;
use App\Services\Game\TeamStatsService;
use App\Services\Players\PlayersService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GameService
{
    public function __construct(
        protected TimelineService $timelines,
        protected StatsService $stats,
        protected TeamStatsService $teamStats,
        protected PlayersService $players
        ) { }

    public function fetch(Games $game): void
    {
        $data = Http::get(
            Str::replace(
                '{gameid}', 
                (string) $game->id, 
                \config('scraper.endpoints.game')
            )
        )->json();
        
        $this->players->save($data['gameData']['players']);
        $this->timelines->save($game, $data['liveData']['plays']['allPlays']);
        $this->teamStats->save($game);
        $this->stats->save($game, $data['liveData']['boxscore']);
    }
}