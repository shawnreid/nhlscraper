<?php

namespace Tests\Unit;

use App\Services\Players\PlayersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayersTest extends TestCase
{
    use RefreshDatabase;

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
}