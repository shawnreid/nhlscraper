<?php

namespace Tests\Unit\Jobs\Seasons;

use App\Jobs\Seasons\GoalieStatsJob;
use App\Models\Seasons\GoalieStats;
use App\Services\Seasons\GoalieStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalieStatsJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GoalieStatsJob fires and can calculate season data
     *
     * @return void
     */
    public function test_season_goalie_stats_job_fires_and_calculates_stats(): void
    {
        $this->fakeGame('game1');

        (new GoalieStatsJob())->handle(new GoalieStatsService());

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
