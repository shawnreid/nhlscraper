<?php

namespace Tests\Feature\Artisan;

use App\Jobs\Alltime\GoalieStatsJob;
use App\Jobs\Alltime\SkaterStatsJob;
use App\Jobs\Alltime\TeamStatsJob;
use App\Models\Games\Games;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AllTimeStatsTest extends TestCase
{
    use RefreshDatabase;

    private array $messages = [
        'skaters' => 'Alltime calculation for skaters queued for synchronization.',
        'goalies' => 'Alltime calculation for goalies queued for synchronization.',
        'teams'   => 'Alltime calculation for teams queued for synchronization.',
        'all'     => 'Alltime calculation for all categories queued for synchronization.',
        'error'   => 'Invalid category. Usage: artisan nhl:alltime {skaters|goalies|teams?}'
    ];

    /**
     * Test artisan nhl:alltime {skaters} can queue job for skaters
     *
     * @return void
    */

    public function test_console_nhl_alltime_queues_skater_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'skaters';
        $this->artisan("nhl:alltime {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(0);

        Queue::assertNotPushed(GoalieStatsJob::class);
        Queue::assertNotPushed(TeamStatsJob::class);
        Queue::assertPushed(SkaterStatsJob::class);
    }

    /**
     * Test artisan nhl:alltime {goalies} can queue job for goalies
     *
     * @return void
    */

    public function test_console_nhl_alltime_queues_goalie_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'goalies';
        $this->artisan("nhl:alltime {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(0);

        Queue::assertNotPushed(TeamStatsJob::class);
        Queue::assertNotPushed(SkaterStatsJob::class);
        Queue::assertPushed(GoalieStatsJob::class);
    }

    /**
     * Test artisan nhl:alltime {teams} can queue job for teams
     *
     * @return void
    */

    public function test_console_nhl_alltime_queues_team_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'teams';
        $this->artisan("nhl:alltime {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(0);

        Queue::assertNotPushed(SkaterStatsJob::class);
        Queue::assertNotPushed(GoalieStatsJob::class);
        Queue::assertPushed(TeamStatsJob::class);
    }

    /**
     * Test artisan nhl:alltime {teams} can queue job for teams
     *
     * @return void
    */

    public function test_console_nhl_alltime_queues_all_job(): void
    {
        Queue::fake();
        Games::factory()->create();

        $this->artisan("nhl:alltime")
            ->expectsOutputToContain($this->messages['all'])
             ->assertExitCode(0);

        Queue::assertPushed(SkaterStatsJob::class);
        Queue::assertPushed(GoalieStatsJob::class);
        Queue::assertPushed(TeamStatsJob::class);
    }

    /**
     * Test invalid artisan nhl:alltime will throw error
     *
     * @return void
    */

    public function test_console_nhl_alltime_returns_invalid_category(): void
    {
        Queue::fake();
        Games::factory()->create();

        $category = 'error';
        $this->artisan("nhl:alltime {$category}")
            ->expectsOutputToContain($this->messages[$category])
             ->assertExitCode(1);

        Queue::assertNotPushed(SkaterStatsJob::class);
        Queue::assertNotPushed(GoalieStatsJob::class);
        Queue::assertNotPushed(TeamStatsJob::class);
    }
}