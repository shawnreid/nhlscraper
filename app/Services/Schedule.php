<?php

namespace App\Services;

use App\Models\Games;
use App\Models\Teams;
use App\Models\Years;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class Schedule 
{
    public function fetch(Years $year): void
    {
        $data = Http::get(
            Str::replace('{season}', $year->year_id, \config('scraper.endpoints.games'))
        )->json();

        $teams = $games = [];
        foreach ($data['dates'] as $date) {
            foreach ($date['games'] as $game) {
                $home = $game['teams']['home'];
                $away = $game['teams']['away'];
                $games[] = [
                    'game_id'       => (int)    $game['gamePk'],
                    'year_id'       => (int)    $year->year_id,
                    'date'          => (string) $date['date'],
                    'game_type_id'  => (int)    substr($game['gamePk'], 5, 1),
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
        
        Teams::upsert($teams, 'id');
        Games::where('year_id', $year->year_id)->delete();
        Games::insert($games);
    }

    protected function formatTeam($team): array
    {
        return [
            'id'    => $team['id'],
            'name'  => $team['name']
        ];
    }
}