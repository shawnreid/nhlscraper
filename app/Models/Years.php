<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    protected $table = 'years';
    protected $fillable = ['id', 'year'];
    public $timestamps = false;

    public static function search(int $year): ?self
    {
        return self::query()
            ->where('year', $year)
            ->orWhere('id', $year)
            ->first();
    }
}
