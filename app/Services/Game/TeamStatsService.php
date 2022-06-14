<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Games\TeamStats;

class TeamStatsService
{
    private array $columns = [
        'goals'         => 0,
        'assists'       => 0,
        'points'        => 0,
        'shots'         => 0,
        'hits'          => 0,
        'pp_goals'      => 0,
        'pp_assists'    => 0,
        'pp_points'     => 0,
        'pim'           => 0,
        'fo_wins'       => 0,
        'fo_taken'      => 0,
        'takeaways'     => 0,
        'giveaways'     => 0,
        'sh_goals'      => 0,
        'sh_assists'    => 0,
        'sh_points'     => 0,
        'blocked_shots' => 0
    ];

    /**
     * Handle team stats
     *
     * @param Games $game
     * @param array $data
     * @return void
    */

    public function handle(Games $game, array &$data): void
    {
        $res = [];

        foreach ($data['liveData']['boxscore']['teams'] as $team) {
            $res[$team['team']['id']] = $this->columns;
            $r = &$res[$team['team']['id']];

            $r['season_id']    = $game->season_id;
            $r['game_id']      = $game->id;
            $r['game_type_id'] = $game->game_type_id;
            $r['team_id']      = $team['team']['id'];

            foreach ($team['players'] as $player) {
                if (isset($player['stats']['skaterStats'])) {
                    $stats = $player['stats']['skaterStats'];
                    $r['goals']         += _s($stats['goals'], 0);
                    $r['assists']       += _s($stats['assists'], 0);
                    $r['points']        += _s($stats['goals'], 0) + _s($stats['assists'], 0);
                    $r['shots']         += _s($stats['shots'], 0);
                    $r['hits']          += _s($stats['hits'], 0);
                    $r['pp_goals']      += _s($stats['powerPlayGoals'], 0);
                    $r['pp_assists']    += _s($stats['powerPlayAssists'], 0);
                    $r['pp_points']     += _s($stats['powerPlayGoals'], 0) + _s($stats['powerPlayAssists'], 0);
                    $r['pim']           += _s($stats['penaltyMinutes'], 0);
                    $r['fo_wins']       += _s($stats['faceOffWins'], 0);
                    $r['fo_taken']      += _s($stats['faceoffTaken'], 0);
                    $r['takeaways']     += _s($stats['takeaways'], 0);
                    $r['giveaways']     += _s($stats['giveaways'], 0);
                    $r['sh_goals']      += _s($stats['shortHandedGoals'], 0);
                    $r['sh_assists']    += _s($stats['shortHandedAssists'], 0);
                    $r['sh_points']     += _s($stats['shortHandedGoals'], 0) + _s($stats['shortHandedAssists'], 0);
                    $r['blocked_shots'] += _s($stats['blocked'], 0);
                }
            }
        }

        TeamStats::deleteGame($game->id);
        TeamStats::insert($res);
    }
}