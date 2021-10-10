<?php

namespace Tests\Unit;

use App\Models\Games\Games;
use App\Models\Seasons;
use App\Services\Game\ScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_games_from_nhl_api(): void
    {
        Http::fake(['*' => $this->fakeJson('schedule')]);

        (new ScheduleService)->fetch($this->getseason());

        $this->assertEquals(Games::count(), 1213);
    }
}