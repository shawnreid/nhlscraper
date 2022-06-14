<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait OverWriteDataScope {

    /**
     * Scope to allow overwrites or not
     *
     * @param Builder $query
     * @param bool    $overwrite
     * @return Builder
    */

    public function scopeOverWriteData(Builder $query, bool $overwrite): Builder
    {
        return $query->when(
            !$overwrite,
            fn($q) => $q->where('imported', 0)
        );
    }
}