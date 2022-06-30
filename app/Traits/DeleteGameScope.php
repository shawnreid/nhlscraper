<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait DeleteGameScope
{
    /**
     * Delete game data
     *
     * @param  Builder  $query
     * @param  mixed  $gameId
     * @return void
     */
    public function scopeDeleteGame(Builder $query, mixed $gameId): void
    {
        $query->where('game_id', $gameId)->delete();
    }
}
