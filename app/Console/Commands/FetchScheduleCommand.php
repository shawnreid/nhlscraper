<?php

namespace App\Console\Commands;

use App\Jobs\FetchScheduleJob;
use App\Models\Years;
use Illuminate\Console\Command;

class FetchScheduleCommand extends Command
{
    protected $signature = 'fetch:schedule {year?}';
    protected $description = 'Fetch schedule for given year or all years.';
    protected int $year;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->year = (int) $this->argument('year');
        return match ($this->year) {
            0       => $this->all(),
            default => $this->year()
        };
    }

    protected function all(): int
    {
        Years::all()->each(function(Years $year): void {
            FetchScheduleJob::dispatch($year);
        });

        $this->info($this->message('all years'));
        return 0;
    }

    protected function year(): int
    {
        $year = Years::search($this->year);

        if (!$year) {
            $this->error('Invalid year. Correct format: 2019 or 20192020.');
            return 1;
        } 

        FetchScheduleJob::dispatch($year);
        $this->info($this->message((string) $this->year));
        return 0;
    }

    protected function message(string $text): string
    {
        return "Schedule for {$text} queued for synchronization. This may take several minutes..";
    }
}
