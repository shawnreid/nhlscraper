<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    protected $table = 'years';
    public $timestamps = false;

    public static function search(int $year): self|null
    {
        return self::query()
            ->where('year', $year)
            ->orWhere('year_id', $year)
            ->first();
    }
}
