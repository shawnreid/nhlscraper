<?php

namespace App\Services\Game;

use App\Models\Game\SkaterBoxScores;
use App\Models\Game\TeamStats;
use Illuminate\Support\Facades\DB;

class TeamStatsService
{
    public function save(int $gameId): void
    {
        TeamStats::insert(
            SkaterBoxScores::where('game_id', $gameId)
                ->select(
                    'team_id',
                    'game_id',
                    ...collect((new TeamStats)->getFillable())->map(function($s) {
                        return DB::raw("SUM({$s}) as {$s}");
                    })
                )->groupBy(['game_id', 'team_id'])
                ->get()->toArray()
        );
    }
}