<?php

namespace App\Console\Commands;

use App\Jobs\Seasons\GoalieStatsJob;
use App\Jobs\Seasons\SkaterStatsJob;
use App\Jobs\Seasons\TeamStatsJob;
use Illuminate\Console\Command;

class SeasonStatsCommand extends Command
{
    protected $signature = 'fetch:season {target}';
    protected $description = 'Fetch stats for target grouped by season.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        return match($this->argument('target')) {
            'skaters' => $this->skaters(),
            'goalies' => $this->goalies(),
            'teams'   => $this->teams(),
            default   => $this->err()
        };
    }

    protected function skaters(): int
    {
        SkaterStatsJob::dispatch();
        return 0;
    }

    protected function goalies(): int
    {
        GoalieStatsJob::dispatch();
        return 0;
    }

    protected function teams(): int
    {
        TeamStatsJob::dispatch();
        return 0;
    }

    protected function err(): int
    {
        $this->error('Invalid target. Usage: artisan fetch:stats {seasons|alltime} {season?}');
        return 1;
    }
}
