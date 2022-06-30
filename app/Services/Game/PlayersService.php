<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Players;

class PlayersService
{
    /**
     * Handle player data
     *
     * @param  array  $data
     * @return void
     */
    public function handle(Games $game, array &$data): void
    {
        foreach ($data['gameData']['players'] as $player) {
            Players::upsert([
                'id'                   => $player['id'],
                'team_id'              => _s($player['currentTeam']['id']),
                'first_name'           => _s($player['firstName']),
                'last_name'            => _s($player['lastName']),
                'primary_number'       => _s($player['primaryNumber']),
                'date_of_birth'        => _s($player['birthDate']),
                'birth_city'           => _s($player['birthCity']),
                'birth_state_province' => _s($player['birthStateProvince']),
                'birth_country'        => _s($player['birthCountry']),
                'nationality'          => _s($player['nationality']),
                'age'                  => _s($player['currentAge']),
                'height'               => isset($player['height']) ? $this->heightToInches($player['height']) : null,
                'weight'               => _s($player['weight']),
                'shoots_catches'       => _s($player['shootsCatches']),
                'position'             => _s($player['primaryPosition']['abbreviation']),
                'alternate_captain'    => _s($player['alternateCaptain'], false),
                'captain'              => _s($player['captain'], false),
                'rookie'               => _s($player['rookie'], false),
                'roster_status'        => isset($player['rosterStatus']) && $player['rosterStatus'] === 'Y' ? 1 : 0,
                'active'               => _s($player['active'], false),
            ], 'id');
        }
    }

    /**
     * Convert height to inches
     *
     * @param  string  $height
     * @return int
     */
    public function heightToInches(string $height): int
    {
        $height = (string) preg_replace('/[^0-9]/', '', $height);
        $feet = (int) substr($height, 0, 1);
        $inches = (int) substr($height, 1);

        return $inches + ($feet * 12);
    }
}
