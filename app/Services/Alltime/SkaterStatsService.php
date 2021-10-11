<?php

namespace App\Services\Alltime;

use App\Models\Games\SkaterStats as GameSkaterStats;
use App\Models\Alltime\SkaterStats as AlltimeSkaterStats;
use Illuminate\Support\Facades\DB;

class SkaterStatsService
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
        'plus_minus',
        'toi',
        'ev_toi',
        'pp_toi',
        'sh_toi',
    ];

    public function save(): void
    {
        $stats = GameSkaterStats::select([
            'player_id',
            'game_type_id',
            DB::raw('COUNT(*) as games_played'),
            ...collect($this->columns)->map(function($s) {
                return DB::raw("SUM({$s}) as {$s}");
            })
        ])->groupBy(['game_type_id', 'player_id'])
          ->get();

        AlltimeSkaterStats::truncate();
        $stats->chunk(100)->each(function($data): void {
            AlltimeSkaterStats::insert($data->toArray());
        });
    }
}