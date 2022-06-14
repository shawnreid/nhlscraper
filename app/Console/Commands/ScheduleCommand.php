<?php

namespace App\Console\Commands;

use App\Models\Seasons\Seasons;
use Illuminate\Console\Command;

class ScheduleCommand extends Command
{
    protected $signature   = 'nhl:schedule {season?} {--overwrite}';
    protected $description = 'Fetch schedule for given season or all seasons.';
    private mixed $season;
    private bool  $overwrite;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Command handler
     *
     * @return int
    */

    public function handle(): int
    {
        $this->season    = $this->argument('season');
        $this->overwrite = $this->option('overwrite') ? true : false;

        $status = match($this->season) {
            null    => $this->all(),
            default => $this->season()
        };

        return $status;
    }

    /**
     * Fetch schedules for all seasons
     *
     * @return int
    */

    protected function all(): int
    {
        Seasons::importAllSchedules($this->overwrite);
        $this->info($this->message('all seasons'));
        return 0;
    }

    /**
     * Fetch schedules for specific season
     *
     * @return int
    */

    protected function season(): int
    {
        $season = Seasons::find($this->season);

        if (!$season) {
            $this->error('Invalid season. Usage: artisan nhl:schedule {20162017|20172018|etc?}');
            return 1;
        }

        Seasons::importSchedule($this->season, $this->overwrite);

        $this->info($this->message($this->season));
        return 0;
    }

    /**
     * Console message
     *
     * @param mixed $text
     * @return string
    */

    protected function message(mixed $text): string
    {
        $count = queueSize('schedule');
        return "Schedule(s) for {$text} queued for synchronization. Jobs in queue: {$count}";
    }
}
