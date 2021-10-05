<?php

namespace App\Services\Game;

use App\Models\GoalieBoxScores;
use App\Models\SkaterBoxScores;

class BoxScoreService
{
    protected array $goalies;
    protected array $skaters;
    protected int $scheduleId;
    protected int $teamId;

    public function fetch(int $scheduleId, array $data): void
    {
        $this->goalies = [];
        $this->skaters = [];
        $this->scheduleId = $scheduleId;
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
            'toi'         => $stats['timeOnIce'] ?? 0,
            'goals'       => $stats['goals'] ?? 0,
            'assists'     => $stats['assists'] ?? 0,
            'pim'         => $stats['pim'] ?? 0,
            'saves'       => $stats['saves'] ?? 0,
            'pp_saves'    => $stats['powerPlaySaves'] ?? 0,
            'sh_saves'    => $stats['shortHandedSaves'] ?? 0,
            'ev_saves'    => $stats['evenSaves'] ?? 0,
            'shots'       => $stats['shots'] ?? 0,
            'pp_shots'    => $stats['powerPlayShotsAgainst'] ?? 0,
            'sh_shots'    => $stats['shortHandedShotsAgainst'] ?? 0,
            'ev_shots'    => $stats['evenShotsAgainst'] ?? 0,
            'svp'         => round($stats['savePercentage'] ?? 0, 2),
            'pp_svp'      => $stats['powerPlaySavePercentage'] ?? 0,
            'sh_svp'      => $stats['shortHandedSavePercentage'] ?? 0,
            'ev_svp'      => $stats['evenStrengthSavePercentage'] ?? 0,
        ];
    }

    protected function skater(array $stats): void
    {
        if (count($stats)) {
            $this->skaters[] = [
                'schedule_id'   => $this->scheduleId,
                'team_id'       => $this->teamId,
                'goals'         => $stats['goals'] ?? 0,
                'assists'       => $stats['assists'] ?? 0,
                'points'        => ($stats['goals'] ?? 0) + ($stats['assists'] ?? 0),
                'shots'         => $stats['shots'] ?? 0,
                'hits'          => $stats['hits'] ?? 0,
                'pp_goals'      => $stats['powerPlayGoals'] ?? 0,
                'pp_assists'    => $stats['powerPlayAssists'] ?? 0,
                'pp_points'     => ($stats['powerPlayGoals'] ?? 0) + ($stats['powerPlayAssists'] ?? 0),
                'pim'           => $stats['penaltyMinutes'] ?? 0,
                'fo_wins'       => $stats['faceOffWins'] ?? 0,
                'fo_taken'      => $stats['faceoffTaken'] ?? 0,
                'takeaways'     => $stats['takeaways'] ?? 0,
                'giveaways'     => $stats['giveaways'] ?? 0,
                'sh_goals'      => $stats['shortHandedGoals'] ?? 0,
                'sh_assists'    => $stats['shortHandedAssists'] ?? 0,
                'sh_points'     => ($stats['shortHandedGoals'] ?? 0) + ($stats['shortHandedAssists'] ?? 0),
                'blocked_shots' => $stats['blocked'] ?? 0,
                'plus_minus'    => $stats['plusMinus'] ?? 0,
                'toi'           => $stats['timeOnIce'] ?? 0,
                'ev_toi'        => $stats['evenTimeOnIce'] ?? 0,
                'pp_toi'        => $stats['powerPlayTimeOnIce'] ?? 0,
                'sh_toi'        => $stats['shortHandedTimeOnIce'] ?? 0,
            ];
        }
    }
}