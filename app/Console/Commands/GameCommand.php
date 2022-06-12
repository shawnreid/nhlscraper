<?php

namespace App\Console\Commands;

use App\Jobs\GameJob;
use App\Models\Games\Games;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class GameCommand extends Command
{
    protected $signature   = 'fetch:games {gameid?}';
    protected $description = 'Fetch data for given game or all games.';
    private int $gameid;

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
        $this->gameid = (int) $this->argument('gameid');
        return match ($this->gameid) {
            0       => $this->all(),
            default => $this->game()
        };
    }

    /**
     * Fetch all games
     *
     * @return int
    */

    private function all(): int
    {
        Games::all()->each(function(Games $games): void {
            GameJob::dispatch($games);
        });

        $this->info($this->message('all games'));

        return 0;
    }

    /**
     * Fetch specific game
     *
     * @return int
    */

    private function game(): int
    {
        $games = Games::search($this->gameid);

        if (!$games) {
            $this->error('Invalid Game ID or games not yet synced.');
            return 1;
        }

        GameJob::dispatch($games);
        $this->info($this->message((string) $this->gameid));
        return 0;
    }

    /**
     * Console message
     *
     * @return string
    */

    private function message(string $text): string
    {
        $count = Queue::size('games');
        return "Game data for {$text} queued for synchronization. Jobs in queue: {$count}";
    }
}
