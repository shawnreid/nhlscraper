<?php

namespace Tests\Unit\Jobs\Seasons;

use App\Jobs\Seasons\SkaterStatsJob;
use App\Models\Seasons\SkaterStats;
use App\Services\Seasons\SkaterStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkaterStatsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test SkaterStatsJob fires and can calculate season data
     *
     * @return void
     */
    public function test_season_skater_stats_job_fires_and_calculates_stats(): void
    {
        $this->fakeGame();

        (new SkaterStatsJob())->handle(new SkaterStatsService());

        $stats = SkaterStats::where('goals', '>', 0)->first();
        $this->assertEquals($stats->game_type_id, 2);
        $this->assertEquals($stats->games_played, 1);
        $this->assertEquals($stats->goals, 1);
        $this->assertEquals($stats->assists, 0);
        $this->assertEquals($stats->points, 1);
        $this->assertEquals($stats->shots, 3);
        $this->assertEquals($stats->hits, 4);
        $this->assertEquals($stats->pp_goals, 0);
        $this->assertEquals($stats->pp_assists, 0);
        $this->assertEquals($stats->pp_points, 0);
        $this->assertEquals($stats->pim, 0);
        $this->assertEquals($stats->fo_wins, 1);
        $this->assertEquals($stats->fo_taken, 1);
        $this->assertEquals($stats->takeaways, 2);
        $this->assertEquals($stats->giveaways, 0);
        $this->assertEquals($stats->sh_goals, 0);
        $this->assertEquals($stats->sh_assists, 0);
        $this->assertEquals($stats->sh_points, 0);
        $this->assertEquals($stats->blocked_shots, 0);
        $this->assertEquals($stats->plus_minus, 1);
        $this->assertEquals($stats->toi, 916);
        $this->assertEquals($stats->ev_toi, 759);
        $this->assertEquals($stats->pp_toi, 157);
        $this->assertEquals($stats->sh_toi, 0);
    }
}
