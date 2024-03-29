<?php

namespace App\Console\Commands;

use App\Jobs\Alltime\GoalieStatsJob;
use App\Jobs\Alltime\SkaterStatsJob;
use App\Jobs\Alltime\TeamStatsJob;
use App\Traits\CommandFunctions;
use Illuminate\Console\Command;

class AllTimeStatsCommand extends Command
{
    use CommandFunctions;

    protected $signature = 'nhl:alltime {category?}';

    protected $description = 'Calculate alltime stats for specified category';

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
        $category = $this->argument('category');

        $status = match ($category) {
            'skaters' => $this->skaters(),
            'goalies' => $this->goalies(),
            'teams'   => $this->teams(),
            null      => $this->all(),
            default   => null
        };

        if (is_null($status)) {
            $this->error('Invalid category. Usage: artisan nhl:alltime {skaters|goalies|teams?}');

            return 1;
        }

        $this->info($this->message($category ?? 'all categories'));

        return $status;
    }

    /**
     * Fetch alltime stats for all categories
     *
     * @return int
     */
    private function all(): int
    {
        $this->skaters();
        $this->goalies();
        $this->teams();

        return 0;
    }

    /**
     * Fetch skater alltime stats
     *
     * @return int
     */
    private function skaters(): int
    {
        SkaterStatsJob::dispatch();

        return 0;
    }

    /**
     * Fetch goalie alltime stats
     *
     * @return int
     */
    private function goalies(): int
    {
        GoalieStatsJob::dispatch();

        return 0;
    }

    /**
     * Fetch team alltime stats
     *
     * @return int
     */
    private function teams(): int
    {
        TeamStatsJob::dispatch();

        return 0;
    }

    /**
     * Console message
     *
     * @return string
     */
    private function message(mixed $text): string
    {
        $count = $this->queueSize('calculate');
        $text = "Alltime calculation for {$text} queued for synchronization. Jobs in queue: {$count}";

        return $this->trimWhiteSpace($text);
    }
}
