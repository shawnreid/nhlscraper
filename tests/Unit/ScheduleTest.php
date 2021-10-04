<?php

namespace Tests\Unit;

use App\Models\Games;
use App\Models\Teams;
use App\Models\Years;
use App\Services\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_schedule_from_nhl_api()
    {
        Http::fake(['*' => $this->fakeJson('schedule')]);

        $schedule = new Schedule;
        $schedule->fetch(Years::search(2019));

        $this->assertEquals(Games::count(), 1334);
        $this->assertEquals(Teams::count(), 39);
    }
}