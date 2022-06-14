<?php

namespace Tests\Feature\Artisan;

use App\Jobs\Seasons\GoalieStatsJob;
use App\Jobs\Seasons\SkaterStatsJob;
use App\Jobs\Seasons\TeamStatsJob;
use App\Models\Games\Games;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SeasonStatsTest extends TestCase
{
    use RefreshDatabase;

    private array $messages = [
        'skaters' => 'Season calculation for skaters queued for synchronization.',
        'goalies' => 'Season calculation for goalies queued for synchronization.',
        'teams'   => 'Season calculation for teams queued for synchronization.',
        'all'     => 'Season calculation for all categories queued for synchronization.',
        'error'   => 'Invalid category. Usage: artisan nhl:season {skaters|goalies|teams?}'
    ];

    /**
     * Test artisan nhl:season {skaters} can queue job for skaters
     *
     * @return void
    */

    public function test_console_nhl_season_queues_skater_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'skaters';
        $this->artisan("nhl:season {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(0);

        Queue::assertNotPushed(GoalieStatsJob::class);
        Queue::assertNotPushed(TeamStatsJob::class);
        Queue::assertPushed(SkaterStatsJob::class);
    }

    /**
     * Test artisan nhl:season {goalies} can queue job for goalies
     *
     * @return void
    */

    public function test_console_nhl_season_queues_goalie_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'goalies';
        $this->artisan("nhl:season {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(0);

        Queue::assertNotPushed(TeamStatsJob::class);
        Queue::assertNotPushed(SkaterStatsJob::class);
        Queue::assertPushed(GoalieStatsJob::class);
    }

    /**
     * Test artisan nhl:season {teams} can queue job for teams
     *
     * @return void
    */

    public function test_console_nhl_season_queues_team_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'teams';
        $this->artisan("nhl:season {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(0);

        Queue::assertNotPushed(SkaterStatsJob::class);
        Queue::assertNotPushed(GoalieStatsJob::class);
        Queue::assertPushed(TeamStatsJob::class);
    }

    /**
     * Test artisan nhl:season {teams} can queue job for teams
     *
     * @return void
    */

    public function test_console_nhl_season_queues_all_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $this->artisan("nhl:season")
            ->expectsOutputToContain($this->messages['all'])
             ->assertExitCode(0);

        Queue::assertPushed(SkaterStatsJob::class);
        Queue::assertPushed(GoalieStatsJob::class);
        Queue::assertPushed(TeamStatsJob::class);
    }

    /**
     * Test invalid artisan nhl:season will throw error
     *
     * @return void
    */

    public function test_console_nhl_season_returns_invalid_category(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'error';
        $this->artisan("nhl:season {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(1);

        Queue::assertNotPushed(SkaterStatsJob::class);
        Queue::assertNotPushed(GoalieStatsJob::class);
        Queue::assertNotPushed(TeamStatsJob::class);
    }
}