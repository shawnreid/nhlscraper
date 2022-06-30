<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ScheduleJob;
use App\Models\Games\Games;
use App\Services\Game\ScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScheduleJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test ScheduleService can parse json and save to database
     *
     * @return void
     */
    public function test_schedule_job_fires_and_imports_schedule_data(): void
    {
        Http::fake(['*' => $this->fakeJson('schedule')]);

        (new ScheduleJob($this->getSeason()))->handle(new ScheduleService());

        $this->assertEquals(Games::count(), 1213);
    }
}
