<?php

namespace Tests\Unit\Services\Game;

use App\Models\Games\Games;
use App\Models\Games\GoalieStats;
use App\Models\Games\SkaterStats;
use App\Models\Games\PlayByPlay;
use App\Services\Game\PlayerStatsService;
use App\Services\Game\PlayersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GameService can parse json and save to database
     *
     * @return void
    */

    public function test_can_fetch_nhl_game_data_from_nhl_api(): void
    {
        $this->fakeGame();

        $game = Games::first();
        $this->assertEquals(SkaterStats::count(), 36);
        $this->assertEquals(GoalieStats::count(), 2);
        $this->assertEquals(PlayByPlay::count(), 382);
        $this->assertNotNull($game->home);
        $this->assertNotNull($game->away);
    }


    /**
     * Test height can be converted to inches
     *
     * @return void
    */

    public function test_height_to_inches_conversion(): void
    {
        $data = [
            "5'11#"     => 71,
            "6'5 "      => 77,
            " 6 ' 5 "   => 77,
            "abcd6'5"   => 77,
            "0'0"       => 0
        ];

        $players = new PlayersService;

        foreach ($data as $height => $expected) {
            $this->assertEquals(
                $players->heightToInches($height),
                $expected
            );
        }
    }

    /**
     * Test time on ice mm:ss can be converted to seconds
     *
     * @return void
    */

    public function test_toi_to_seconds_conversion(): void
    {
        $data = [
            '0'     => 0,
            '04:09' => 249,
            '08:28' => 508,
            '10:04' => 604,
            '10:38' => 638,
            '60:00' => 3600
        ];

        $stats = new PlayerStatsService;
        foreach ($data as $toi => $expected) {
            $this->assertEquals($stats->toiToSeconds($toi), $expected);
        }
    }
}