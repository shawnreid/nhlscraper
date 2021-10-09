<?php

namespace App\Services\Game;

use App\Models\Game\GoalieBoxScores;
use App\Models\Game\SkaterBoxScores;

class BoxScoreService
{
    protected array $goalies;
    protected array $skaters;
    protected int $scheduleId;
    protected int $teamId;

    public function fetch(int $scheduleId, array $data): void
    {
        $this->scheduleId = $scheduleId;
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
        
        GoalieBoxScores::where('schedule_id', $scheduleId)->delete();
        GoalieBoxScores::insert($this->goalies);

        SkaterBoxScores::where('schedule_id', $scheduleId)->delete();
        SkaterBoxScores::insert($this->skaters);
    }

    protected function goalie(array $stats): void
    {
        $this->goalies[] = [
            'schedule_id' => $this->scheduleId,
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
                'schedule_id'   => $this->scheduleId,
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