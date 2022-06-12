<?php

namespace Tests\Feature\Artisan;

use App\Jobs\ScheduleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_fetch_games_all_seasons(): void
    {
        Queue::fake();
        $this->artisan('fetch:schedule')
             ->assertExitCode(0);
        Queue::assertPushed(ScheduleJob::class);
    }
}
