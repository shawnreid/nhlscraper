<?php

namespace App\Models\Seasons;

use App\Jobs\ScheduleJob;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    protected $table = 'seasons';
    protected $fillable = ['id', 'season'];
    public $timestamps = false;

    /**
     * Import schedule for season
     *
     * @param  int  $season
     * @param  bool $overwrite
     * @return void
    */

    public static function importSchedule(int $season, bool $overwrite = true): void
    {
        $season = self::query()
            ->overwriteSeasons($overwrite)
            ->find($season);

        if ($season) {
            ScheduleJob::dispatch($season);
        }
    }

    /**
     * Import schedule for all seasons
     *
     * @param  bool $overwrite
     * @return void
    */

    public static function importAllSchedules(bool $overwrite = true): void
    {
        self::query()
            ->overwriteSeasons($overwrite)
            ->get()
            ->each(fn(Seasons $season) =>
                ScheduleJob::dispatch($season)
            );
    }

    /**
     * Scope to allow overwrites or not
     *
     * @param Builder $query
     * @param bool    $overwrite
     * @return Builder
    */

    public function scopeOverWriteSeasons(Builder $query, bool $overwrite): Builder
    {
        return $query->when(
            !$overwrite,
            fn($q) => $q->where('imported', 0)
        );
    }
}
