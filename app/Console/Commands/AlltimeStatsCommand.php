<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Alltime\GoalieStatsJob;
use App\Jobs\Alltime\SkaterStatsJob;
use App\Jobs\Alltime\TeamStatsJob;
use Illuminate\Support\Facades\Queue;

class AlltimeStatsCommand extends Command
{
    protected $signature   = 'fetch:alltime {target}';
    protected $description = 'Fetch stats grouped by alltime for target';

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
        $target = $this->argument('target');

        $status = match($target) {
            'skaters' => $this->skaters(),
            'goalies' => $this->goalies(),
            'teams'   => $this->teams(),
            default   => $this->err()
        };

        $this->info($this->message($target));

        return $status;
    }

    /**
     * Fetch skater all-time stats
     *
     * @return int
    */

    private function skaters(): int
    {
        SkaterStatsJob::dispatch();
        return 0;
    }

    /**
     * Fetch goalie all-time stats
     *
     * @return int
    */

    private function goalies(): int
    {
        GoalieStatsJob::dispatch();
        return 0;
    }

    /**
     * Fetch team all-time stats
     *
     * @return int
    */

    private function teams(): int
    {
        TeamStatsJob::dispatch();
        return 0;
    }

    /**
     * Return error
     *
     * @return int
    */

    private function err(): int
    {
        $this->error('Invalid target. Usage: artisan fetch:alltime');
        return 1;
    }

    /**
     * Console message
     *
     * @return string
    */

    private function message(string $text): string
    {
        $count = Queue::size('calculate');
        return "Alltime calculation for {$text} queued for synchronization. Jobs in queue: {$count}";
    }
}
