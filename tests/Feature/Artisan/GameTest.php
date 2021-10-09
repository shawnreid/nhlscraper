<?php

namespace Tests\Feature\Artisan;

use App\Jobs\FetchGameJob;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_fetch_schedule_invalid_game()
    {
        $this->artisan('fetch:games 2')
             ->expectsOutput('Invalid Game ID or schedule not yet synced.')
             ->assertExitCode(1);
    }

    public function test_console_fetch_schedule_valid_game()
    {
        Queue::fake();
        Schedule::factory()->create();
        $this->artisan('fetch:games 2019020001')
             ->expectsOutput('Invalid Game ID or schedule not yet synced.')
             ->assertExitCode(0);
        Queue::assertPushed(FetchGameJob::class);
    }

    public function test_console_fetch_games_for_all_years()
    {
        Queue::fake();
        Schedule::factory()->create();
        $this->artisan('fetch:games')
             ->expectsOutput('Successfully fetched game data for all games.')
             ->assertExitCode(0);
        Queue::assertPushed(FetchGameJob::class);
    }
}
