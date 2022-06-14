<?php

namespace Tests\Unit;

use App\Services\Game\StatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsTest extends TestCase
{
    use RefreshDatabase;

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

        $stats = new StatsService;
        foreach ($data as $toi => $expected) {
            $this->assertEquals($stats->toiToSeconds($toi), $expected);
        }
    }
}