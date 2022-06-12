<?php

namespace Tests\Unit;

use App\Models\Games\Games;
use App\Models\Games\GoalieStats;
use App\Models\Games\SkaterStats;
use App\Models\Games\Timelines;
use App\Models\Players\Players;
use App\Services\Game\StatsService;
use App\Services\Game\TeamStatsService;
use App\Services\Game\PlayByPlayService;
use App\Services\Game\GameService;
use App\Services\Players\PlayersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_game_data_from_nhl_api(): void
    {
        Http::fake(['*' => $this->fakeJson('game')]);
        $games = Games::factory()->create();

        (new GameService)->fetch($games);

        $this->assertEquals(SkaterStats::count(), 36);
        $this->assertEquals(GoalieStats::count(), 2);
        $this->assertEquals(Timelines::count(), 382);
        $this->assertEquals(Players::count(), 43);
    }

}