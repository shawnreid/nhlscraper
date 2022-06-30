<?php

namespace Tests\Unit\Jobs;

use App\Jobs\GameJob;
use App\Models\Games\Games;
use App\Models\Games\GoalieStats;
use App\Models\Games\PlayByPlay;
use App\Models\Games\SkaterStats;
use App\Services\Game\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GameJob fires and imports game data
     *
     * @return void
     */
    public function test_game_job_fires_and_imports_game_data(): void
    {
        Http::fake(['*' => $this->fakeJson('game1')]);
        $games = Games::factory()->create();

        (new GameJob($games))->handle(new GameService());

        $game = Games::first();
        $this->assertEquals(SkaterStats::count(), 36);
        $this->assertEquals(GoalieStats::count(), 2);
        $this->assertEquals(PlayByPlay::count(), 382);
        $this->assertNotNull($game->home);
        $this->assertNotNull($game->away);
    }

    /**
     * Test GameJob fires and imports game data from secondary endpoint when stats missing
     *
     * @return void
     */
    public function test_game_job_fires_and_imports_game_data_from_secondary_endpoint_when_stats_missing(): void
    {
        $gameEndpoint   = 'https://statsapi.web.nhl.com/api/v1/game/*';
        $playerEndpoint = 'https://statsapi.web.nhl.com/api/v1/people/*';
        Http::fake([
            $gameEndpoint   => $this->fakeJson('game2'),
            $playerEndpoint => $this->fakeJson('player1')
        ]);
        $games = Games::factory()->create([
            'id'           => '1927020199',
            'season_id'    => '19271928',
            'date'         => '1928-03-14',
        ]);

        (new GameJob($games))->handle(new GameService());

        $game = Games::first();
        $this->assertEquals(SkaterStats::count(), 18);
        $this->assertEquals(GoalieStats::count(), 2);
        $this->assertEquals(PlayByPlay::count(), 17);
        $this->assertNotNull($game->home);
        $this->assertNotNull($game->away);
    }
}
