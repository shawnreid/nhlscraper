<?php

namespace Tests\Feature\Artisan;

use App\Jobs\GameJob;
use App\Models\Games\Games;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test artisan nhl:games {gameid} can fetch a game
     *
     * @return void
    */

    public function test_console_nhl_games_valid_game(): void
    {
        Queue::fake();
        Games::factory()->create();

        $gameId = 2019020001;
        $this->artisan("nhl:games {$gameId}")
             ->assertExitCode(0);

        Queue::assertPushed(GameJob::class);
    }

    /**
     * Test artisan nhl:games can fetch all games
     *
     * @return void
    */

    public function test_console_nhl_games_for_all_seasons(): void
    {
        Queue::fake();
        Games::factory()->create();
        $this->artisan('nhl:games')
             ->assertExitCode(0);
        Queue::assertPushed(GameJob::class);
    }
}
