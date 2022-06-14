<?php

namespace App\Services\Seasons;

use App\Models\Games\SkaterStats as GameSkaterStats;
use App\Models\Seasons\SkaterStats as SeasonSkaterStats;
use Illuminate\Support\Facades\DB;

class SkaterStatsService
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
        'plus_minus',
        'toi',
        'ev_toi',
        'pp_toi',
        'sh_toi',
    ];

    /**
     * Handle skater season stats
     *
     * @return void
    */

    public function handle(): void
    {
        $stats = GameSkaterStats::select([
            'season_id',
            'game_type_id',
            'player_id',
            DB::raw('COUNT(*) as games_played'),
            ...collect($this->columns)->map(function($s) {
                return DB::raw("SUM({$s}) as {$s}");
            })
        ])->groupBy(['season_id', 'game_type_id', 'player_id'])
          ->get();

        SeasonSkaterStats::truncate();
        $stats->chunk(500)->each(fn($data) =>
            SeasonSkaterStats::insert($data->toArray())
        );
    }
}