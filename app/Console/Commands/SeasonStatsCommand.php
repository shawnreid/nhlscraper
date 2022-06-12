<?php

namespace App\Console\Commands;

use App\Jobs\Seasons\GoalieStatsJob;
use App\Jobs\Seasons\SkaterStatsJob;
use App\Jobs\Seasons\TeamStatsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class SeasonStatsCommand extends Command
{
    protected $signature   = 'fetch:season {target}';
    protected $description = 'Fetch stats for target grouped by season.';

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
     * Fetch skater season stats
     *
     * @return int
    */

    protected function skaters(): int
    {
        SkaterStatsJob::dispatch();
        return 0;
    }

    /**
     * Fetch goalie season stats
     *
     * @return int
    */

    protected function goalies(): int
    {
        GoalieStatsJob::dispatch();
        return 0;
    }

    /**
     * Fetch team season stats
     *
     * @return int
    */

    protected function teams(): int
    {
        TeamStatsJob::dispatch();
        return 0;
    }

    /**
     * Return error
     *
     * @return int
    */

    protected function err(): int
    {
        $this->error('Invalid target. Usage: artisan fetch:season {season}');
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
        return "Season calculation for {$text} queued for synchronization. Jobs in queue: {$count}";
    }
}
