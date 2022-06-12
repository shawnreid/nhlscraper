<?php

namespace App\Models\Seasons;

use App\Jobs\ScheduleJob;
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
     * @return void
    */

    public static function importSchedule(int $season): void
    {
        ScheduleJob::dispatch(self::findOrFail($season));
    }

    /**
     * Import schedule for all seasons
     *
     * @return void
    */

    public static function importAllSchedules(): void
    {
        self::all()->each(fn(Seasons $season) =>
            ScheduleJob::dispatch($season)
        );
    }
}
