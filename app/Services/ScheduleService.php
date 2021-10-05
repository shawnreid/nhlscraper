<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Years;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ScheduleService
{
    public function fetch(Years $year): void
    {
        $data = Http::get(
            Str::replace(
                '{season}', 
                (string) $year->year_id, 
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
                        'year_id'       => $year->year_id,
                        'date'          => $date['date'],
                        'game_type_id'  => $gameType,
                        'home_id'       => $home['team']['id'],
                        'away_id'       => $away['team']['id'],
                        'status'        => $game['status']['codedGameState']
                    ];
                }
            }
        }

        Schedule::upsert($games, 'id');
    }
}