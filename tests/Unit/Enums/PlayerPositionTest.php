<?php

namespace Tests\Unit\Enums;

use App\Enums\PlayerPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerPositionTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_position_enum_returns_correct_name(): void
    {
        $positions = [
            'C'  => 'Center',
            'LW' => 'Left Wing',
            'RW' => 'Right Wing',
            'LD' => 'Left Defense',
            'RD' => 'Right Defense',
            'G'  => 'Goalie'
        ];

        foreach ($positions as $abr => $name) {
            $this->assertEquals(PlayerPosition::from($abr)->name(), $name);
        }
    }
}