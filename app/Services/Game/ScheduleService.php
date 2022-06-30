<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Seasons\Seasons;
use Illuminate\Support\Facades\Http;

class ScheduleService
{
    /**
     * Handle schedule data
     *
     * @param  Seasons  $season
     * @return void
     */
    public function handle(Seasons $season): void
    {
        $data = Http::get("https://statsapi.web.nhl.com/api/v1/schedule?season={$season->id}")->json();

        $games = [];
        foreach ($data['dates'] as $date) {
            foreach ($date['games'] as $game) {
                $gameType = substr($game['gamePk'], 5, 1);
                if (in_array($gameType, [2, 3])) {
                    $home = $game['teams']['home'];
                    $away = $game['teams']['away'];
                    $games[] = [
                        'id'            => $game['gamePk'],
                        'season_id'     => $season->id,
                        'date'          => $date['date'],
                        'game_type_id'  => $gameType,
                        'home_id'       => $home['team']['id'],
                        'away_id'       => $away['team']['id'],
                        'status'        => $game['status']['codedGameState'],
                    ];
                }
            }
        }

        $season->imported = 1;
        $season->save();

        Games::upsert($games, 'id');
    }
}
