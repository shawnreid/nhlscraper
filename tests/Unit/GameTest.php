<?php

namespace Tests\Unit;

use App\Models\GoalieBoxScores;
use App\Models\Schedule;
use App\Models\SkaterBoxScores;
use App\Models\Timelines;
use App\Services\Game\BoxScoreService;
use App\Services\Game\TimelineService;
use App\Services\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_game_data_from_nhl_api()
    {
        Http::fake(['*' => $this->fakeJson('game')]);
        $schedule = Schedule::factory()->create();

        $game = new GameService(
            new BoxScoreService,
            new TimelineService
        );
        $game->fetch($schedule);

        $this->assertEquals(SkaterBoxScores::count(), 36);
        $this->assertEquals(GoalieBoxScores::count(), 2);
        $this->assertEquals(Timelines::count(), 382);
    }
}