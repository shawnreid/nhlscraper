<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Services\Game\StatsService;
use App\Services\Game\TimelineService;
use App\Services\Game\TeamStatsService;
use App\Services\Players\PlayersService;
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
        $data = Http::get("https://statsapi.web.nhl.com/api/v1/game/{$game->id}/feed/live?site=en_nhl")->json();

        $this->players->save($data['gameData']['players']);
        $this->timelines->save($game, $data['liveData']['plays']['allPlays']);
        $this->teamStats->save($game, $data['liveData']['boxscore']);
        $this->stats->save($game, $data['liveData']['boxscore']);
    }
}