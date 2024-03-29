<?php

namespace App\Models\Games;

use App\Traits\DeleteGameScope;
use Illuminate\Database\Eloquent\Model;

class TeamStats extends Model
{
    use DeleteGameScope;

    protected $table = 'team_stats_game';

    public $timestamps = false;
}
