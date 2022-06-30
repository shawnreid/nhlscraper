<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use Illuminate\Support\Facades\Http;

class GameService
{
    private array $pipes = [
        PlayerStatsService::class,
        TeamStatsService::class,
        PlayByPlayService::class,
        PlayersService::class,
    ];

    /**
     * Handle game date
     *
     * @param  Games  $game
     * @return void
     */
    public function handle(Games $game): void
    {
        $data = Http::get("https://statsapi.web.nhl.com/api/v1/game/{$game->id}/feed/live?site=en_nhl")->json();

        foreach ($this->pipes as $pipe) {
            $service = new $pipe;
            $service->handle($game, $data);
        }

        $game->imported = 1;
        $game->save();
    }
}
