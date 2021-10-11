<?php

namespace App\Services\Seasons;

use App\Models\Games\TeamStats as GameTeamStats;
use App\Models\Seasons\TeamStats as SeasonTeamStats;
use Illuminate\Support\Facades\DB;

class TeamStatsService
{
    protected array $columns = [
        'goals',
        'assists',
        'points',
        'shots',
        'hits',
        'pp_goals',
        'pp_assists',
        'pp_points',
        'pim',
        'fo_wins',
        'fo_taken',
        'takeaways',
        'giveaways',
        'sh_goals',
        'sh_assists',
        'sh_points',
        'blocked_shots',
    ];

    public function save(): void
    {
        $stats = GameTeamStats::select([
            'season_id',
            'game_type_id',
            'team_id',
            DB::raw('COUNT(*) as games_played'),
            ...collect($this->columns)->map(function($s) {
                return DB::raw("SUM({$s}) as {$s}");
            })
        ])->groupBy(['season_id', 'game_type_id', 'team_id'])
          ->get();

        SeasonTeamStats::truncate();
        $stats->chunk(100)->each(function($data): void {
            SeasonTeamStats::insert($data->toArray());
        });
    }
}