<?php

namespace Tests\Unit\Jobs\Alltime;

use App\Jobs\Alltime\TeamStatsJob;
use App\Models\Alltime\TeamStats;
use App\Services\Alltime\TeamStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamStatsJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test TeamStatsJob fires and can calculate all time data
     *
     * @return void
     */
    public function test_alltime_team_stats_job_fires_and_calculates_stats(): void
    {
        $this->fakeGame('game1');

        (new TeamStatsJob())->handle(new TeamStatsService());

        $stats = TeamStats::first();
        $this->assertEquals($stats->goals, 3);
        $this->assertEquals($stats->assists, 6);
        $this->assertEquals($stats->points, 9);
        $this->assertEquals($stats->shots, 26);
        $this->assertEquals($stats->hits, 44);
        $this->assertEquals($stats->pp_goals, 0);
        $this->assertEquals($stats->pp_assists, 0);
        $this->assertEquals($stats->pp_points, 0);
        $this->assertEquals($stats->pim, 10);
        $this->assertEquals($stats->fo_wins, 42);
        $this->assertEquals($stats->fo_taken, 73);
        $this->assertEquals($stats->takeaways, 7);
        $this->assertEquals($stats->giveaways, 7);
        $this->assertEquals($stats->sh_goals, 0);
        $this->assertEquals($stats->sh_assists, 0);
        $this->assertEquals($stats->sh_points, 0);
        $this->assertEquals($stats->blocked_shots, 17);
    }
}
