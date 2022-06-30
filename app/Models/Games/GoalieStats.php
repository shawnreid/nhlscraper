<?php

namespace App\Models\Games;

use App\Traits\DeleteGameScope;
use Illuminate\Database\Eloquent\Model;

class GoalieStats extends Model
{
    use DeleteGameScope;

    protected $table = 'goalie_stats_game';
    public $timestamps = false;

}
