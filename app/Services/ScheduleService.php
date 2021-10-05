<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Teams;
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
                \config('scraper.endpoints.games')
            )
        )->json();

        $teams = $games = [];
        foreach ($data['dates'] as $date) {
            foreach ($date['games'] as $game) {
                $gameType =  substr($game['gamePk'], 5, 1);
                if (in_array($gameType, [2, 3])) {
                    $home = $game['teams']['home'];
                    $away = $game['teams']['away'];
                    $games[] = [
                        'id'            => (int)    $game['gamePk'],
                        'year_id'       => (int)    $year->year_id,
                        'date'          => (string) $date['date'],
                        'game_type_id'  => (int)    $gameType,
                        'home_id'       => (int)    $home['team']['id'],
                        'away_id'       => (int)    $away['team']['id'],
                        'home_score'    => (int)    $home['score'],
                        'away_score'    => (int)    $away['score'],
                        'status'        => (int)    $game['status']['codedGameState']
                    ];

                    $teams[$home['team']['id']] = $this->formatTeam($home['team']);
                    $teams[$away['team']['id']] = $this->formatTeam($away['team']);
                }
            }
        }

        Schedule::upsert($games, 'id');
        Teams::upsert(array_diff_key($teams, Teams::pluck('name', 'id')->toArray()), 'id');
    }

    protected function formatTeam(array $team): array
    {
        return [
            'id'    => $team['id'],
            'name'  => $team['name']
        ];
    }
}