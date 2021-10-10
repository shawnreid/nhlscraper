<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Services\Game\BoxScoreService;
use App\Services\Game\TimelineService;
use App\Services\Game\TeamStatsService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GameService
{
    public function __construct(
        protected TeamStatsService $teamStats,
        protected BoxScoreService $boxScores,
        protected TimelineService $timeLines
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
            
        $this->timeLines->save($game->id, $data['liveData']['plays']['allPlays']);
        $this->boxScores->save($game->id, $data['liveData']['boxscore']);
        $this->teamStats->save($game->id);
    }
}