<?php

namespace App\Console\Commands;

use App\Jobs\ScheduleJob;
use App\Models\Seasons\Seasons;
use Illuminate\Console\Command;

class ScheduleCommand extends Command
{
    protected $signature = 'fetch:schedule {season?}';
    protected $description = 'Fetch schedule for given season or all seasons.';
    protected int $season;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->season = (int) $this->argument('season');
        return match ($this->season) {
            0       => $this->all(),
            default => $this->season()
        };
    }

    protected function all(): int
    {
        Seasons::all()->each(function(Seasons $season): void {
            ScheduleJob::dispatch($season);
        });

        $this->info($this->message('all seasons'));
        return 0;
    }

    protected function season(): int
    {
        $season = Seasons::search($this->season);

        if (!$season) {
            $this->error('Invalid season. Correct format: 2019 or 20192020.');
            return 1;
        } 

        ScheduleJob::dispatch($season);
        $this->info($this->message((string) $this->season));
        return 0;
    }

    protected function message(string $text): string
    {
        return "Games for {$text} queued for synchronization. This may take several minutes..";
    }
}
