<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Model;

class TeamStats extends Model
{
    protected $table = 'games_team_stats';
    public $fillable = [
        'goals',
        'assists',
        'points',
        'shots',
        'hits',
        'pp_goals',
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
}
