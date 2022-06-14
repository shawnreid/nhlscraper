<?php

namespace Tests\Feature\Artisan;

use App\Jobs\ScheduleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test artisan nhl:schedule can fetch schedule for all seasons
     *
     * @return void
    */

    public function test_console_nhl_games_all_seasons(): void
    {
        Queue::fake();
        $this->artisan('nhl:schedule')
             ->assertExitCode(0);
        Queue::assertPushed(ScheduleJob::class);
    }
}
