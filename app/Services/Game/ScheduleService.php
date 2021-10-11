<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Seasons;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ScheduleService
{
    public function fetch(Seasons $season): void
    {
        $data = Http::get(
            Str::replace(
                '{season}', 
                (string) $season->id, 
                \config('scraper.endpoints.schedule')
            )
        )->json();
            
        $games = [];
        foreach ($data['dates'] as $date) {
            foreach ($date['games'] as $game) {
                $gameType =  substr($game['gamePk'], 5, 1);
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
                        'status'        => $game['status']['codedGameState']
                    ];
                }
            }
        }

        Games::upsert($games, 'id');
    }
}