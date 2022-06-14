<?php

namespace App\Console\Commands;

use App\Jobs\ScheduleJob;
use App\Models\Seasons\Seasons;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class ScheduleCommand extends Command
{
    protected $signature   = 'nhl:schedule {season?}';
    protected $description = 'Fetch schedule for given season or all seasons.';
    protected int $season;

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
        $this->season = (int) $this->argument('season');
        return match ($this->season) {
            0       => $this->all(),
            default => $this->season()
        };
    }

    /**
     * Fetch schedules for all seasons
     *
     * @return int
    */

    protected function all(): int
    {
        Seasons::importAllSchedules();

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
        Seasons::importSchedule($this->season);

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
        $count = number_format(Queue::size('schedule'));
        return "Schedule(s) for {$text} queued for synchronization. Jobs in queue: {$count}";
    }
}
