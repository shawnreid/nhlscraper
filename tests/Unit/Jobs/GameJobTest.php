<?php

namespace Tests\Unit\Jobs;

use App\Jobs\GameJob;
use App\Models\Games\Games;
use App\Models\Games\GoalieStats;
use App\Models\Games\SkaterStats;
use App\Models\Games\PlayByPlay;
use App\Services\Game\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GameJob fires
     *
     * @return void
    */

    public function test_game_job_fires(): void
    {
        Http::fake(['*' => $this->fakeJson('game')]);
        $games = Games::factory()->create();

        (new GameJob($games))->handle(new GameService());

        $this->assertEquals(SkaterStats::count(), 36);
        $this->assertEquals(GoalieStats::count(), 2);
        $this->assertEquals(PlayByPlay::count(), 382);
    }
}