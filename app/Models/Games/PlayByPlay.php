<?php

namespace App\Models\Games;

use App\Traits\DeleteGameScope;
use Illuminate\Database\Eloquent\Model;

class PlayByPlay extends Model
{
    use DeleteGameScope;

    protected $table = 'game_play_by_play';

    protected $fillable = [
        'game_id',
        'event',
        'code',
        'desc_full',
        'desc_short',
        'period',
        'time',
        'time_left',
        'player1_id',
        'player2_id',
        'player1_type',
        'player2_type',
        'home_score',
        'away_score',
        'x_coord',
        'y_coord',
        'team_id',
    ];

    public $timestamps = false;
}
