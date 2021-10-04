<?php

namespace App\Console\Commands;

use App\Jobs\FetchScheduleJob;
use App\Models\Years;
use Illuminate\Console\Command;

class FetchSchedule extends Command
{
    protected $signature = 'fetch:schedule {year?}';
    protected $description = 'Fetch schedule for given year or all years.';
    protected $year;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->year = $this->argument('year');
        return match ($this->year) {
            null    => $this->all(),
            default => $this->year()
        };
    }

    protected function all(): int
    {
        Years::all()->each(fn($year) => FetchScheduleJob::dispatch($year));
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
        $this->info($this->message($this->year));
        return 0;
    }

    protected function message($text): string
    {
        return "Schedule for {$text} queued for synchronization. This may take several minutes.";
    }
}
