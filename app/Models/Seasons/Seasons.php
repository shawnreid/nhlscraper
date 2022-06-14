<?php

namespace App\Models\Seasons;

use App\Jobs\ScheduleJob;
use App\Traits\OverWriteDataScope;
use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    use OverWriteDataScope;

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
            ->overWriteData($overwrite)
            ->find($season);

        if ($season) {
            ScheduleJob::dispatch($season);
        }
    }

    /**
     * Import schedule from a range of seasons
     *
     * @param  mixed $start
     * @param  mixed $end
     * @param  bool  $overwrite
     * @return void
    */

    public static function importSchedules(mixed $start, mixed $end, bool $overwrite = true): void
    {
        self::query()
            ->overWriteData($overwrite)
            ->whereBetween('id', [$start, $end])
            ->get()
            ->each(fn(Seasons $season) =>
                ScheduleJob::dispatch($season)
            );
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
            ->overWriteData($overwrite)
            ->get()
            ->each(fn(Seasons $season) =>
                ScheduleJob::dispatch($season)
            );
    }
}
