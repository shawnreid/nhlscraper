<?php

namespace Database\Factories\Games;

use App\Models\Games\Games;
use Illuminate\Database\Eloquent\Factories\Factory;

class GamesFactory extends Factory
{
    protected $model = Games::class;

    public function definition(): array
    {
        return [
            'id'           => '2019020001',
            'season_id'      => 20192020,
            'date'         => '2019-10-02',
            'game_type_id' => 2,
            'home_id'      => 10,
            'away_id'      => 9,
            'status'       => 7
        ];
    }
}
