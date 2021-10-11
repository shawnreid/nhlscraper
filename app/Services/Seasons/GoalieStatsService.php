<?php

namespace App\Services\Seasons;

use App\Models\Games\GoalieStats as GameGoalieStats;
use App\Models\Seasons\GoalieStats as SeasonGoalieStats;
use Illuminate\Support\Facades\DB;

class GoalieStatsService
{
    protected array $columns = [
        'toi',
        'goals',
        'assists',
        'pim',
        'saves',
        'pp_saves',
        'sh_saves',
        'ev_saves',
        'shots',
        'pp_shots',
        'sh_shots',
        'ev_shots'
    ];

    public function save(): void
    {
        $stats = GameGoalieStats::select([
            'season_id',
            'game_type_id',
            'player_id',
            DB::raw('COUNT(*) as games_played'),
            ...collect($this->columns)->map(function($s) {
                return DB::raw("SUM({$s}) as {$s}");
            }),
            DB::raw('SUM(svp) / COUNT(*) as svp'),
            DB::raw('SUM(pp_svp) / COUNT(*) as pp_svp'),
            DB::raw('SUM(sh_svp) / COUNT(*) as sh_svp'),
            DB::raw('SUM(ev_svp) / COUNT(*) as ev_svp'),
        ])->groupBy(['season_id', 'game_type_id', 'player_id'])
          ->get();

        SeasonGoalieStats::truncate();
        $stats->chunk(100)->each(function($data): void {
            SeasonGoalieStats::insert($data->toArray());
        });
    }
}