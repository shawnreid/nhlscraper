<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Games\PlayByPlay;

class PlayByPlayService
{

    /**
     * Save timeline data
     *
     * @param Games $game
     * @param array $data
     * @return void
    */

    public function save(Games $game, array $data): void
    {
        $results = collect([]);
        foreach ($data as $d) {
            $results[] = [
                'season_id'     => $game->season_id,
                'game_id'       => $game->id,
                'game_type_id'  => $game->game_type_id,
                'event'         => _s($d['result']['event']),
                'code'          => _s($d['result']['eventCode']),
                'desc_full'     => _s($d['result']['description']),
                'desc_short'    => _s($d['result']['secondaryType']),
                'period'        => _s($d['about']['period']),
                'time'          => _s($d['about']['periodTime']),
                'time_left'     => _s($d['about']['periodTimeRemaining']),
                'player1_id'    => _s($d['players'][0]['player']['id']),
                'player2_id'    => _s($d['players'][1]['player']['id']),
                'player1_type'  => _s($d['players'][0]['playerType']),
                'player2_type'  => _s($d['players'][1]['playerType']),
                'home_score'    => _s($d['about']['goals']['home'], 0),
                'away_score'    => _s($d['about']['goals']['away'], 0),
                'x_coord'       => _s($d['coordinates']['x']),
                'y_coord'       => _s($d['coordinates']['y']),
                'team_id'       => _s($d['team']['id']),
            ];
        }

        PlayByPlay::where('game_id', $game->id)->delete();
        $results->chunk(100)->each(function($data): void {
            PlayByPlay::insert($data->toArray());
        });
    }
}