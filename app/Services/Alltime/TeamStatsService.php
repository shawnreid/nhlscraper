<?php

namespace App\Services\Alltime;

use App\Models\Alltime\TeamStats as AlltimeTeamStats;
use App\Models\Games\TeamStats as GameTeamStats;
use Illuminate\Support\Facades\DB;

class TeamStatsService
{
    private array $columns = [
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

    /**
     * Handle all time team stats
     *
     * @return void
     */
    public function handle(): void
    {
        $stats = GameTeamStats::select([
            'game_type_id',
            'team_id',
            DB::raw('COUNT(*) as games_played'),
            ...collect($this->columns)->map(function ($s) {
                return DB::raw("SUM({$s}) as {$s}");
            }),
        ])->groupBy(['game_type_id', 'team_id'])
          ->get();

        AlltimeTeamStats::truncate();
        $stats->chunk(500)->each(fn ($data) => AlltimeTeamStats::insert($data->toArray())
        );
    }
}
