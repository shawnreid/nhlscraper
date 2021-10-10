<?php

namespace Tests\Unit;

use App\Models\Games\Games;
use App\Models\Games\GoalieBoxScores;
use App\Models\Games\SkaterBoxScores;
use App\Models\Games\Timelines;
use App\Services\Game\BoxScoreService;
use App\Services\Game\TeamStatsService;
use App\Services\Game\TimelineService;
use App\Services\Game\GameService;
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

        $game = new GameService(
            new TeamStatsService,
            new BoxScoreService,
            new TimelineService
        );
        $game->fetch($games);

        $this->assertEquals(SkaterBoxScores::count(), 36);
        $this->assertEquals(GoalieBoxScores::count(), 2);
        $this->assertEquals(Timelines::count(), 382);
    }
}