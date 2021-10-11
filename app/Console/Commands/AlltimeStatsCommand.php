<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Alltime\GoalieStatsJob;
use App\Jobs\Alltime\SkaterStatsJob;
use App\Jobs\Alltime\TeamStatsJob;

class AlltimeStatsCommand extends Command
{
    protected $signature = 'fetch:alltime {target}';
    protected $description = 'Fetch stats grouped by alltime for target';

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
