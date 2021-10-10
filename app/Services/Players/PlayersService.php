<?php

namespace App\Services\Players;

use App\Models\Players\Players;

class PlayersService
{
    public function save(array $data): void
    {
        foreach ($data as $player) {
            Players::upsert([
                'id'                   => $player['id'],
                'team_id'              => $player['currentTeam']['id'],
                'first_name'           => $player['firstName'],
                'last_name'            => $player['lastName'],
                'primary_number'       => $player['primaryNumber'],
                'date_of_birth'        => $player['birthDate'],
                'birth_city'           => $player['birthCity'],
                'birth_state_province' => _s($player['birthStateProvince'], null),
                'birth_country'        => $player['birthCountry'],
                'nationality'          => $player['nationality'],
                'age'                  => $player['currentAge'],
                'height'               => $this->inches($player['height']),
                'weight'               => $player['weight'],
                'shoots_catches'       => $player['shootsCatches'],
                'primary_position'     => $player['primaryPosition']['code'],
                'alternate_captain'    => $player['alternateCaptain'],
                'captain'              => $player['captain'],
                'rookie'               => $player['rookie'],
                'roster_status'        => $player['rosterStatus'] === 'Y' ? 1 : 0,
                'active'               => $player['active'],
            ], 'id');
        }
    }

    protected function inches($height): int
    {
        $height = preg_replace('/[^0-9]/', '', $height);
        $feet   = substr($height, 0, 1);
        $inches = substr($height, 1);
        return $inches + ($feet * 12);
    }
}