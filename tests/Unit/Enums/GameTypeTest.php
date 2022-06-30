<?php

namespace Tests\Unit\Enums;

use App\Enums\GameType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_type_enum_returns_correct_name(): void
    {
        $positions = [
            1 => 'Pre Season',
            2 => 'Regular Season',
            3 => 'Playoffs'
        ];

        foreach ($positions as $id => $name) {
            $this->assertEquals(GameType::from($id)->name(), $name);
        }
    }
}