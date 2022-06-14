<?php

namespace App\Console\Commands;

use App\Models\Seasons\Seasons;
use Illuminate\Console\Command;

class ScheduleCommand extends Command
{
    protected $signature   = 'nhl:schedule {option?} {--overwrite}';
    protected $description = 'Fetch schedule for given season or all seasons.';
    private mixed $option;
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
        $this->option    = $this->argument('option');
        $this->overwrite = $this->option('overwrite') ? true : false;
        $length          = strlen(strval($this->option));

        $status = match(true) {
            $length === 8  => $this->season(),
            $length === 17 => $this->seasons(),
            $length === 0  => $this->all(),
            default        => null
        };

        if (is_null($status)) {
            $this->error('Invalid season or range. Usage: artisan nhl:alltime {20162017|20162017-20172018?}');
            return 1;
        }

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
        Seasons::importSchedule($this->option, $this->overwrite);

        $this->info($this->message($this->option));
        return 0;
    }

    /**
     * Fetch schedules for range of seasons
     *
     * @return int
    */

    protected function seasons(): int
    {
        $option = str_replace(chr(32), '', explode('-', $this->option));

        Seasons::importSchedules($option[0], $option[1], $this->overwrite);

        $this->info($this->message($this->option));
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
