<?php

namespace App\Services\Players;

use App\Models\Players\Players;
use App\Models\Players\Positions;

class PlayersService
{
    public function save(array $data): void
    {
        $positions = Positions::pluck('id', 'abbreviation');
        
        foreach ($data as $player) {
            Players::upsert([
                'id'                   => $player['id'],
                'team_id'              => _s($player['currentTeam']['id'], null),
                'first_name'           => _s($player['firstName'], null),
                'last_name'            => _s($player['lastName'], null),
                'primary_number'       => _s($player['primaryNumber'], null),
                'date_of_birth'        => _s($player['birthDate'], null),
                'birth_city'           => _s($player['birthCity'], null),
                'birth_state_province' => _s($player['birthStateProvince'], null),
                'birth_country'        => _s($player['birthCountry'], null),
                'nationality'          => _s($player['nationality'], null),
                'age'                  => _s($player['currentAge'], null),
                'height'               => isset($player['height']) ? $this->inches($player['height']) : null,
                'weight'               => _s($player['weight'], null),
                'shoots_catches'       => _s($player['shootsCatches'], null),
                'position_id'          => isset($player['primaryPosition']['abbreviation']) ? $positions[$player['primaryPosition']['abbreviation']] : null,
                'alternate_captain'    => _s($player['alternateCaptain'], false),
                'captain'              => _s($player['captain'], false),
                'rookie'               => _s($player['rookie'], false),
                'roster_status'        => isset($player['rosterStatus']) && $player['rosterStatus'] === 'Y' ? 1 : 0,
                'active'               => _s($player['active'], false),
            ], 'id');
        }
    }

    public function inches(string $height): int
    {
        $height = (string) preg_replace('/[^0-9]/', '', $height);
        $feet   = (int)    substr($height, 0, 1);
        $inches = (int)    substr($height, 1);
        return $inches + ($feet * 12);
    }
}