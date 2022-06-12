<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Services\Game\StatsService;
use App\Services\Game\PlayByPlayService;
use App\Services\Game\TeamStatsService;
use App\Services\Players\PlayersService;
use Illuminate\Support\Facades\Http;

class GameService
{

    /**
     * Fetch game date
     *
     * @param Games $game
     * @return void
    */

    public function fetch(Games $game): void
    {
        $data = Http::get("https://statsapi.web.nhl.com/api/v1/game/{$game->id}/feed/live?site=en_nhl")->json();

        (new PlayersService)->save($data['gameData']['players']);
        (new PlayByPlayService)->save($game, $data['liveData']['plays']['allPlays']);
        (new TeamStatsService)->save($game, $data['liveData']['boxscore']);
        (new StatsService)->save($game, $data['liveData']['boxscore']);
    }
}