<?php

namespace App\Console\Commands;

use App\Models\Games\Games;
use App\Traits\CommandFunctions;
use Illuminate\Console\Command;

class GameCommand extends Command
{
    use CommandFunctions;

    protected $signature = 'nhl:games {gameid?} {--overwrite}';

    protected $description = 'Fetch data for given game or all games.';

    private mixed $option;

    private bool  $overwrite;

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
        $this->option = $this->argument('gameid') ?? null;
        $this->overwrite = $this->option('overwrite') ? true : false;
        $length = strlen(strval($this->option));

        $status = match (true) {
            $length === 10 => $this->game(),
            $length === 21 => $this->games(),
            $length === 8  => $this->season(),
            $length === 17 => $this->seasons(),
            $length === 0  => $this->all(),
            default        => null
        };

        if (is_null($status)) {
            $this->error('Invalid game or range. Usage: artisan nhl:games {2020020001|2020020001-2020020020?}');

            return 1;
        }

        return $status;
    }

    /**
     * Fetch specific game
     *
     * @return int
     */
    private function game(): int
    {
        Games::importGame($this->option, $this->overwrite);

        $this->info($this->message('game'));

        return 0;
    }

    /**
     * Fetch range of games
     *
     * @return int
     */
    private function games(): int
    {
        $option = $this->splitRange($this->option);

        Games::importGames($option[0], $option[1], $this->overwrite);

        $this->info($this->message('game range'));

        return 0;
    }

    /**
     * Fetch season
     *
     * @return int
     */
    private function season(): int
    {
        Games::importSeason($this->option, $this->overwrite);

        $this->info($this->message('season'));

        return 0;
    }

    /**
     * Fetch range of seasons
     *
     * @return int
     */
    private function seasons(): int
    {
        $option = $this->splitRange($this->option);

        Games::importSeasons($option[0], $option[1], $this->overwrite);

        $this->info($this->message('season range'));

        return 0;
    }

    /**
     * Fetch all games
     *
     * @return int
     */
    private function all(): int
    {
        Games::importAllGames($this->overwrite);

        $this->info($this->message('all games'));

        return 0;
    }

    /**
     * Console message
     *
     * @return string
     */
    private function message(mixed $text): string
    {
        $count = $this->queueSize('games');

        $text = "Game data for {$text} {$this->option} queued for synchronization. Jobs in queue: {$count}";

        return $this->trimWhiteSpace($text);
    }
}
