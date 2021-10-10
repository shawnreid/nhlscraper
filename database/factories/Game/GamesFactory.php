<?php

namespace Database\Factories\Game;

use App\Models\Game\Games;
use Illuminate\Database\Eloquent\Factories\Factory;

class GamesFactory extends Factory
{
    protected $model = Games::class;

    public function definition()
    {
        return [
            'id'           => '2019020001',
            'year_id'      => 20192020,
            'date'         => '2019-10-02',
            'game_type_id' => 2,
            'home_id'      => 10,
            'away_id'      => 9,
            'status'       => 7
        ];
    }
}
