<?php

namespace Tests\Feature\Artisan;

use App\Jobs\FetchScheduleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_fetch_games_invalid_year()
    {
        $this->artisan('fetch:schedule 2')
             ->expectsOutput('Invalid year. Correct format: 2019 or 20192020.')
             ->assertExitCode(1);
    }

    public function test_console_fetch_games_valid_year()
    {
        Queue::fake();
        $this->artisan('fetch:schedule 2019')
             ->expectsOutput('Games for 2019 queued for synchronization. This may take several minutes..')
             ->assertExitCode(0);
        Queue::assertPushed(FetchScheduleJob::class);
    }

    public function test_console_fetch_games_all_years()
    {
        Queue::fake();
        $this->artisan('fetch:schedule')
             ->expectsOutput('Games for all years queued for synchronization. This may take several minutes..')
             ->assertExitCode(0);
        Queue::assertPushed(FetchScheduleJob::class);
    }
}
