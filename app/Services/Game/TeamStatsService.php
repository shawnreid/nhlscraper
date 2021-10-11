<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Games\SkaterStats;
use App\Models\Games\TeamStats;
use Illuminate\Support\Facades\DB;

class TeamStatsService
{
    protected array $columns = [
        'goals',
        'assists',
        'points',
        'shots',
        'hits',
        'pp_goals',
        'pp_points',
        'pim',
        'fo_wins',
        'fo_taken',
        'takeaways',
        'giveaways',
        'sh_goals',
        'sh_assists',
        'sh_points',
        'blocked_shots',
    ];

    public function save(Games $game, array $data): void
    {
        $results = [];
        foreach ($data['teams'] as $team) {
            $tid = $team['team']['id'];
            $r = &$results;
            $r[$tid]['season_id'] = $game->season_id;
            $r[$tid]['game_id'] = $game->id;
            $r[$tid]['game_type_id'] = $game->game_type_id;
            $r[$tid]['team_id'] = $tid;
            foreach ($team['players'] as $player) {
                if (isset($player['stats']['skaterStats'])) {
                    $stats = $player['stats']['skaterStats'];
                    $r[$tid]['goals']         = _s($r[$tid]['goals'], 0) + _s($stats['goals'], 0);
                    $r[$tid]['assists']       = _s($r[$tid]['assists'], 0) + _s($stats['assists'], 0);
                    $r[$tid]['points']        = _s($r[$tid]['points'], 0) + _s($stats['goals'], 0) + _s($stats['assists'], 0);
                    $r[$tid]['shots']         = _s($r[$tid]['shots'], 0) + _s($stats['shots'], 0);
                    $r[$tid]['hits']          = _s($r[$tid]['hits'], 0) + _s($stats['hits'], 0);
                    $r[$tid]['pp_goals']      = _s($r[$tid]['pp_goals'], 0) + _s($stats['powerPlayGoals'], 0);
                    $r[$tid]['pp_assists']    = _s($r[$tid]['pp_goals'], 0) + _s($stats['powerPlayAssists'], 0);
                    $r[$tid]['pp_points']     = _s($r[$tid]['pp_points'], 0) + _s($stats['powerPlayGoals'], 0) + _s($stats['powerPlayAssists'], 0);
                    $r[$tid]['pim']           = _s($r[$tid]['pim'], 0) + _s($stats['penaltyMinutes'], 0);
                    $r[$tid]['fo_wins']       = _s($r[$tid]['fo_wins'], 0) + _s($stats['faceOffWins'], 0);
                    $r[$tid]['fo_taken']      = _s($r[$tid]['fo_taken'], 0) + _s($stats['faceoffTaken'], 0);
                    $r[$tid]['takeaways']     = _s($r[$tid]['takeaways'], 0) + _s($stats['takeaways'], 0);
                    $r[$tid]['giveaways']     = _s($r[$tid]['giveaways'], 0) + _s($stats['giveaways'], 0);
                    $r[$tid]['sh_goals']      = _s($r[$tid]['sh_goals'], 0) + _s($stats['shortHandedGoals'], 0);
                    $r[$tid]['sh_assists']    = _s($r[$tid]['sh_assists'], 0) + _s($stats['shortHandedAssists'], 0);
                    $r[$tid]['sh_points']     = _s($r[$tid]['sh_points'], 0) + _s($stats['shortHandedGoals'], 0) + _s($stats['shortHandedAssists'], 0);
                    $r[$tid]['blocked_shots'] = _s($r[$tid]['blocked_shots'], 0) + _s($stats['blocked'], 0);
                }
            }
        }

        TeamStats::where('game_id', $game->id)->delete();
        TeamStats::insert($results);
    }
}