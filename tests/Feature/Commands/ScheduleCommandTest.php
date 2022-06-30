<?php

namespace Tests\Feature\Commands;

use App\Jobs\ScheduleJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleCommandTest extends TestCase
{
    use RefreshDatabase;

    private array $messages = [
        'season'  => 'Schedule(s) for {year} queued for synchronization',
        'all'     => 'Schedule(s) for all seasons queued for synchronization',
        'error'   => 'Invalid season or range. Usage: artisan nhl:alltime {20162017|20162017-20172018?}',
    ];

    /**
     * Test artisan nhl:schedule {season} can fetch schedule for single season
     *
     * @return void
     */
    public function test_console_artisan_nhl_schedule_queues_specific_season(): void
    {
        Queue::fake();

        $season = 20162017;
        $this->artisan("nhl:schedule {$season}")
             ->expectsOutputToContain(str_replace('{year}', $season, $this->messages['season']))
             ->assertExitCode(0);

        Queue::assertPushed(ScheduleJob::class);
    }

    /**
     * Test artisan nhl:schedule {season-season} can fetch schedule for range of seasons
     *
     * @return void
     */
    public function test_console_artisan_nhl_schedule_queues_range_of_seasons(): void
    {
        Queue::fake();

        $season = '20162017-20172018';
        $this->artisan("nhl:schedule {$season}")
             ->expectsOutputToContain(str_replace('{year}', $season, $this->messages['season']))
             ->assertExitCode(0);

        Queue::assertPushed(ScheduleJob::class);
    }

    /**
     * Test artisan nhl:schedule can fetch schedule for all seasons
     *
     * @return void
     */
    public function test_console_artisan_nhl_schedule_queues_all_seasons(): void
    {
        Queue::fake();

        $this->artisan('nhl:schedule')
             ->expectsOutputToContain($this->messages['all'])
             ->assertExitCode(0);

        Queue::assertPushed(ScheduleJob::class);
    }

    /**
     * Test invalid artisan nhl:schedule will throw error
     *
     * @return void
     */
    public function test_console_artisan_nhl_schedule_returns_invalid_category(): void
    {
        Queue::fake();

        $seasons = [
            '216217',
            '1',
            '212-224',
            'abc',
        ];
        foreach ($seasons as $season) {
            $this->artisan("nhl:schedule {$season}")
                ->expectsOutputToContain($this->messages['error'])
                ->assertExitCode(1);

            Queue::assertNotPushed(ScheduleJob::class);
        }
    }
}
