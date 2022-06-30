<?php

namespace Tests\Unit\Services\Seasons;

use App\Models\Seasons\GoalieStats;
use App\Services\Seasons\GoalieStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalieStatsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GoalieStatsService can calculate seasons data
     *
     * @return void
    */

    public function test_can_calculate_seasons_goalie_stats(): void
    {
        $this->fakeGame();
        (new GoalieStatsService())->handle();

        $stats = GoalieStats::first();
        $this->assertEquals($stats->toi, 3507);
        $this->assertEquals($stats->goals, 0);
        $this->assertEquals($stats->assists, 0);
        $this->assertEquals($stats->pim, 0);
        $this->assertEquals($stats->saves, 37);
        $this->assertEquals($stats->pp_saves, 9);
        $this->assertEquals($stats->sh_saves, 0);
        $this->assertEquals($stats->ev_saves, 28);
        $this->assertEquals($stats->shots, 42);
        $this->assertEquals($stats->pp_shots, 10);
        $this->assertEquals($stats->sh_shots, 0);
        $this->assertEquals($stats->ev_shots, 32);
        $this->assertEquals($stats->svp, 88.1);
        $this->assertEquals($stats->sh_svp, 0);
        $this->assertEquals($stats->ev_svp, 87.5);
    }
}