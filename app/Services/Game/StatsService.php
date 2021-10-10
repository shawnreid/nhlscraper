<?php

namespace App\Services\Game;

use App\Models\Games\GoalieStats;
use App\Models\Games\SkaterStats;

class StatsService
{
    protected array $goalies;
    protected array $skaters;
    protected int $gameId;
    protected int $teamId;

    public function save(int $gameId, array $data): array
    {
        $this->gameId = $gameId;
        $this->skaters = $this->goalies = [];
        foreach ($data['teams'] as $team) {
            $this->teamId = $team['team']['id'];
            foreach ($team['players'] as $player) {
                match($player['position']['name']) {
                    'Goalie' => $this->goalie($player['stats']['goalieStats'] ?? []),
                    default  => $this->skater($player['stats']['skaterStats'] ?? [])
                };
            }
        }
        
        GoalieStats::where('game_id', $gameId)->delete();
        GoalieStats::insert($this->goalies);

        SkaterStats::where('game_id', $gameId)->delete();
        SkaterStats::insert($this->skaters);

        return [
            'skaters' => $this->skaters,
            'goalies' => $this->goalies,
        ];
    }

    protected function goalie(array $stats): void
    {
        $this->goalies[] = [
            'game_id' => $this->gameId,
            'team_id'     => $this->teamId,
            'toi'         => _s($stats['timeOnIce'], 0),
            'goals'       => _s($stats['goals'], 0),
            'assists'     => _s($stats['assists'], 0),
            'pim'         => _s($stats['pim'], 0),
            'saves'       => _s($stats['saves'], 0),
            'pp_saves'    => _s($stats['powerPlaySaves'], 0),
            'sh_saves'    => _s($stats['shortHandedSaves'], 0),
            'ev_saves'    => _s($stats['evenSaves'], 0),
            'shots'       => _s($stats['shots'], 0),
            'pp_shots'    => _s($stats['powerPlayShotsAgainst'], 0),
            'sh_shots'    => _s($stats['shortHandedShotsAgainst'], 0),
            'ev_shots'    => _s($stats['evenShotsAgainst'], 0),
            'svp'         => round(_s($stats['savePercentage'], 0), 2),
            'pp_svp'      => _s($stats['powerPlaySavePercentage'], 0),
            'sh_svp'      => _s($stats['shortHandedSavePercentage'], 0),
            'ev_svp'      => _s($stats['evenStrengthSavePercentage'], 0),
        ];
    }

    protected function skater(array $stats): void
    {
        if (count($stats)) {
            $this->skaters[] = [
                'game_id'   => $this->gameId,
                'team_id'       => $this->teamId,
                'goals'         => _s($stats['goals']),
                'assists'       => _s($stats['assists']),
                'points'        => _s($stats['goals']) + _s($stats['assists']),
                'shots'         => _s($stats['shots']),
                'hits'          => _s($stats['hits']),
                'pp_goals'      => _s($stats['powerPlayGoals']),
                'pp_assists'    => _s($stats['powerPlayAssists']),
                'pp_points'     => _s($stats['powerPlayGoals']) + _s($stats['powerPlayAssists']),
                'pim'           => _s($stats['penaltyMinutes'], 0),
                'fo_wins'       => _s($stats['faceOffWins'], 0),
                'fo_taken'      => _s($stats['faceoffTaken'], 0),
                'takeaways'     => _s($stats['takeaways'], 0),
                'giveaways'     => _s($stats['giveaways'], 0),
                'sh_goals'      => _s($stats['shortHandedGoals'], 0),
                'sh_assists'    => _s($stats['shortHandedAssists'], 0),
                'sh_points'     => _s($stats['shortHandedGoals']) + _s($stats['shortHandedAssists']),
                'blocked_shots' => _s($stats['blocked'], 0),
                'plus_minus'    => _s($stats['plusMinus'], 0),
                'toi'           => _s($stats['timeOnIce'], 0),
                'ev_toi'        => _s($stats['evenTimeOnIce'], 0),
                'pp_toi'        => _s($stats['powerPlayTimeOnIce'], 0),
                'sh_toi'        => _s($stats['shortHandedTimeOnIce'], 0),
            ];
        }
    }
}