<?php

namespace App\Console\Commands;

use App\Jobs\FetchGameJob;
use App\Models\Schedule;
use Illuminate\Console\Command;

class FetchGameCommand extends Command
{
    protected $signature = 'fetch:games {gameid?}';
    protected $description = 'Fetch data for given game or all games.';
    protected mixed $gameid;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->gameid = (int) $this->argument('gameid');
        return match ($this->gameid) {
            0       => $this->all(),
            default => $this->game()
        };
    }

    protected function all(): int
    {
        Schedule::all()->each(function(Schedule $schedule): void {
            FetchGameJob::dispatch($schedule);
        });

        $this->info($this->message('all games'));

        return 0;
    }

    protected function game(): int
    {
        $schedule = Schedule::search($this->gameid);

        if (!$schedule) {
            $this->error('Invalid Game ID or schedule not yet synced.');
            return 1;
        } 

        FetchGameJob::dispatch($schedule);
        $this->info($this->message((string) $this->gameid));
        return 0;
    }

    protected function message(string $text): string
    {
        return "Successfully fetched game data for {$text}.";
    }
}
