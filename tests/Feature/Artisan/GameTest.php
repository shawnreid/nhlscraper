<?php

namespace Tests\Feature\Artisan;

use App\Jobs\FetchGameJob;
use App\Models\Games\Games;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_fetch_games_invalid_game(): void
    {
        $this->artisan('fetch:games 2')
             ->expectsOutput('Invalid Game ID or games not yet synced.')
             ->assertExitCode(1);
    }

    public function test_console_fetch_games_valid_game(): void
    {
        Queue::fake();
        Games::factory()->create();

        $gameId = 2019020001;
        $this->artisan("fetch:games {$gameId}")
             ->expectsOutput("Successfully fetched game data for {$gameId}.")
             ->assertExitCode(0);
             
        Queue::assertPushed(FetchGameJob::class);
    }

    public function test_console_fetch_games_for_all_years(): void
    {
        Queue::fake();
        Games::factory()->create();
        $this->artisan('fetch:games')
             ->expectsOutput('Successfully fetched game data for all games.')
             ->assertExitCode(0);
        Queue::assertPushed(FetchGameJob::class);
    }
}
