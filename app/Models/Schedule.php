<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = [
        'id',
        'date',
        'game_type_id',
        'home_id',
        'away_id',
        'home_score',
        'away_score',
        'status'
    ];
    public $timestamps = false;

    public static function search(int $id): ?self
    {
        return self::query()
            ->where('id', $id)
            ->first();
    }

    public function home(): HasOne
    {
        return $this->hasOne(Teams::class, 'id', 'home_id');
    }

    public function away(): HasOne
    {
        return $this->hasOne(Teams::class, 'id', 'away_id');
    }
}
