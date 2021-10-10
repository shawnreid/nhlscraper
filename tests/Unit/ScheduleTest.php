<?php

namespace Tests\Unit;

use App\Models\Game\Games;
use App\Models\Years;
use App\Services\ScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_games_from_nhl_api()
    {
        Http::fake(['*' => $this->fakeJson('schedule')]);

        $schedule = new ScheduleService;
        $schedule->fetch(Years::search(2019));

        $this->assertEquals(Games::count(), 1213);
    }
}