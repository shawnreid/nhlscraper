<?php

namespace Tests\Unit;

use App\Models\Games\Games;
use App\Services\Game\ScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test ScheduleService can parse json and save to database
     *
     * @return void
    */

    public function test_can_nhl_games_from_nhl_api(): void
    {
        Http::fake(['*' => $this->fakeJson('schedule')]);

        (new ScheduleService)->fetch($this->getSeason());

        $this->assertEquals(Games::count(), 1213);
    }
}