<?php

namespace App\Models\Games;

use App\Traits\DeleteGameScope;
use Illuminate\Database\Eloquent\Model;

class SkaterStats extends Model
{
    use DeleteGameScope;

    protected $table = 'skater_stats_game';
    public $timestamps = false;

}
