<?php

namespace App\Console\Commands;

use App\Jobs\Seasons\GoalieStatsJob;
use App\Jobs\Seasons\SkaterStatsJob;
use App\Jobs\Seasons\TeamStatsJob;
use App\Traits\CommandFunctions;
use Illuminate\Console\Command;

class SeasonStatsCommand extends Command
{
    use CommandFunctions;

    protected $signature = 'nhl:season {category?}';

    protected $description = 'Calculate season stats for specified category';

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
            $this->error('Invalid category. Usage: artisan nhl:season {skaters|goalies|teams?}');

            return 1;
        }

        $this->info($this->message($category ?? 'all categories'));

        return $status;
    }

    /**
     * Fetch season stats for all categories
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
     * Console message
     *
     * @return string
     */
    private function message(mixed $text): string
    {
        $count = $this->queueSize('calculate');

        $text = "Season calculation for {$text} queued for synchronization. Jobs in queue: {$count}";

        return $this->trimWhiteSpace($text);
    }
}
