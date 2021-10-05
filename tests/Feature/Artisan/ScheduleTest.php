<?php

namespace Tests\Feature\Artisan;

use App\Jobs\FetchScheduleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_fetch_schedule_invalid_year()
    {
        $this->artisan('fetch:schedule 2')
             ->expectsOutput('Invalid year. Correct format: 2019 or 20192020.')
             ->assertExitCode(1);
    }

    public function test_console_fetch_schedule_valid_year()
    {
        Queue::fake();
        $this->artisan('fetch:schedule 2019')
             ->expectsOutput('Schedule for 2019 queued for synchronization. This may take several minutes..')
             ->assertExitCode(0);
        Queue::assertPushed(FetchScheduleJob::class);
    }

    public function test_console_fetch_schedule_all_years()
    {
        Queue::fake();
        $this->artisan('fetch:schedule')
             ->expectsOutput('Schedule for all years queued for synchronization. This may take several minutes..')
             ->assertExitCode(0);
        Queue::assertPushed(FetchScheduleJob::class);
    }
}
