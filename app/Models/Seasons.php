<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    protected $table = 'seasons';
    protected $fillable = ['id', 'season'];
    public $timestamps = false;

    public static function search(int $season): ?self
    {
        return self::query()
            ->where('season', $season)
            ->orWhere('id', $season)
            ->first();
    }
}
