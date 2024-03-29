<?php

namespace App\Jobs;

use App\Models\Games\Games;
use App\Services\Game\GameService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GameJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Games $games)
    {
        $this->onQueue('games');
    }

    public function handle(GameService $game): void
    {
        $game->handle($this->games);
    }
}
