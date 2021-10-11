<?php

namespace Tests\Feature\Artisan;

use App\Jobs\ScheduleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_fetch_games_invalid_season(): void
    {
        $this->artisan('fetch:schedule 2')
             ->expectsOutput('Invalid season. Correct format: 2019 or 20192020.')
             ->assertExitCode(1);
    }

    public function test_console_fetch_games_valid_season(): void
    {
        Queue::fake();
        $this->artisan('fetch:schedule 2019')
             ->expectsOutput('Games for 2019 queued for synchronization. This may take several minutes..')
             ->assertExitCode(0);
        Queue::assertPushed(ScheduleJob::class);
    }

    public function test_console_fetch_games_all_seasons(): void
    {
        Queue::fake();
        $this->artisan('fetch:schedule')
             ->expectsOutput('Games for all seasons queued for synchronization. This may take several minutes..')
             ->assertExitCode(0);
        Queue::assertPushed(ScheduleJob::class);
    }
}
