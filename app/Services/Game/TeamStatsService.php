<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Games\SkaterStats;
use App\Models\Games\TeamStats;
use Illuminate\Support\Facades\DB;

class TeamStatsService
{
    public function save(Games $game): void
    {
        TeamStats::insert(
            SkaterStats::where('game_id', $game->id)
                ->select(
                    'season_id',
                    'game_id',
                    'game_type_id',
                    'team_id',
                    ...collect((new TeamStats)->getFillable())->map(function($s) {
                        return DB::raw("SUM({$s}) as {$s}");
                    })
                )->groupBy(['season_id', 'game_id', 'game_type_id', 'team_id'])
                ->get()->toArray()
        );
    }
}