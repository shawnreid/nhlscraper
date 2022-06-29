<?php

namespace Tests\Feature\Commands;

use App\Jobs\GameJob;
use App\Models\Games\Games;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class GamesCommandTest extends TestCase
{
    use RefreshDatabase;

    private array $messages = [
        'season'  => 'Game data for season {year} queued for synchronization.',
        'seasons' => 'Game data for season range {year} queued for synchronization.',
        'game'    => 'Game data for game {year} queued for synchronization.',
        'games'   => 'Game data for game range {year} queued for synchronization.',
        'all'     => 'Game data for all games queued for synchronization.',
        'error'   => 'Invalid game or range. Usage: artisan nhl:games {2020020001|2020020001-2020020020?}'
    ];

    /**
     * Test artisan nhl:games {gameId} can fetch a single game
     *
     * @return void
    */

    public function test_console_nhl_games_queues_specific_game(): void
    {
        Queue::fake();

        Games::factory()->create();

        $gameId = 2019020001;
        $this->artisan("nhl:games {$gameId}")
             ->expectsOutputToContain(str_replace('{year}', $gameId, $this->messages['game']))
             ->assertExitCode(0);

        Queue::assertPushed(GameJob::class);
    }

    /**
     * Test artisan nhl:games {games-games} can range of games
     *
     * @return void
    */

    public function test_console_nhl_schedule_queues_range_of_games(): void
    {
        Queue::fake();

        Games::factory()->create();

        $gameId = '2019020001-2019020005';
        $this->artisan("nhl:games {$gameId}")
             ->expectsOutputToContain(str_replace('{year}', $gameId, $this->messages['games']))
             ->assertExitCode(0);

        Queue::assertPushed(GameJob::class);
    }

    /**
     * Test artisan nhl:games {season} can fetch games for a specific season
     *
     * @return void
    */

    public function test_console_nhl_games_queues_games_for_specific_season(): void
    {
        Queue::fake();

        Games::factory()->create();

        $gameId = '20192020';
        $this->artisan("nhl:games {$gameId}")
             ->expectsOutputToContain(str_replace('{year}', $gameId, $this->messages['season']))
             ->assertExitCode(0);

        Queue::assertPushed(GameJob::class);
    }

    /**
     * Test artisan nhl:games {season-season} can fetch games for range of seasons
     *
     * @return void
    */

    public function test_console_nhl_schedule_queues_range_of_seasons(): void
    {
        Queue::fake();

        Games::factory()->create();

        $gameId = '20192020-20202021';
        $this->artisan("nhl:games {$gameId}")
             ->expectsOutputToContain(str_replace('{year}', $gameId, $this->messages['seasons']))
             ->assertExitCode(0);

        Queue::assertPushed(GameJob::class);
    }

    /**
     * Test artisan nhl:games can fetch all games
     *
     * @return void
    */

    public function test_console_nhl_games_queues_all_games(): void
    {
        Queue::fake();

        Games::factory()->create();

        $this->artisan('nhl:games')
             ->expectsOutputToContain($this->messages['all'])
             ->assertExitCode(0);

        Queue::assertPushed(GameJob::class);
    }

    /**
     * Test invalid artisan nhl:games will throw error
     *
     * @return void
    */

    public function test_console_nhl_games_returns_invalid_category(): void
    {
        Queue::fake();

        Games::factory()->create();

        $seasons = [
            '216217',
            '1',
            '212-224',
            'abc'
        ];
        foreach ($seasons as $season) {
            $this->artisan("nhl:games {$season}")
                ->expectsOutputToContain($this->messages['error'])
                ->assertExitCode(1);

            Queue::assertNotPushed(ScheduleJob::class);
        }
    }
}
