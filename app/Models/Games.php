<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Games extends Model
{
    protected $table = 'games';
    protected $fillable = [
        'game_id',
        'date',
        'game_type_id',
        'home_id',
        'away_id',
        'home_score',
        'away_score',
        'status'
    ];
    public $timestamps = false;

    public function home(): HasOne
    {
        return $this->hasOne(Teams::class, 'home_id');
    }

    public function away(): HasOne
    {
        return $this->hasOne(Teams::class, 'away_id');
    }
}
