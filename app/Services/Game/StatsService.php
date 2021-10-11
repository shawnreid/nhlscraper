<?php

namespace App\Services\Game;

use App\Models\Games\Games;
use App\Models\Games\GoalieStats;
use App\Models\Games\SkaterStats;
use Illuminate\Support\Facades\Http;

class StatsService
{
    protected Games $game;
    protected array $goalies;
    protected array $skaters;
    protected int $playerId;
    protected int $teamId;

    public function save(Games $game, array $data): void
    {
        $this->game = $game;
        $this->skaters = $this->goalies = [];
        foreach ($data['teams'] as $team) {
            $this->teamId = $team['team']['id'];
            foreach ($team['players'] as $player) {
                $this->playerId = $player['person']['id'];
                match($player['position']['name']) {
                    'Goalie' => $this->goalie(_s($player['stats']['goalieStats'], [])),
                    default  => $this->skater(_s($player['stats']['skaterStats'], []))
                };
            }
        }
        
        GoalieStats::where('game_id', $game->id)->delete();
        GoalieStats::insert($this->goalies);

        SkaterStats::where('game_id', $game->id)->delete();
        SkaterStats::insert($this->skaters);
    }

    protected function goalie(array $stats): void
    {
        $this->goalies[] = [
            'game_id'      => $this->game->id,
            'game_type_id' => $this->game->game_type_id,
            'season_id'    => $this->game->season_id,
            'team_id'      => $this->teamId,
            'player_id'    => $this->playerId,
            'toi'          => _s($stats['timeOnIce'], 0),
            'goals'        => _s($stats['goals'], 0),
            'assists'      => _s($stats['assists'], 0),
            'pim'          => _s($stats['pim'], 0),
            'saves'        => _s($stats['saves'], 0),
            'pp_saves'     => _s($stats['powerPlaySaves'], 0),
            'sh_saves'     => _s($stats['shortHandedSaves'], 0),
            'ev_saves'     => _s($stats['evenSaves'], 0),
            'shots'        => _s($stats['shots'], 0),
            'pp_shots'     => _s($stats['powerPlayShotsAgainst'], 0),
            'sh_shots'     => _s($stats['shortHandedShotsAgainst'], 0),
            'ev_shots'     => _s($stats['evenShotsAgainst'], 0),
            'svp'          => round(_s($stats['savePercentage'], 0), 2),
            'pp_svp'       => _s($stats['powerPlaySavePercentage'], 0),
            'sh_svp'       => _s($stats['shortHandedSavePercentage'], 0),
            'ev_svp'       => _s($stats['evenStrengthSavePercentage'], 0),
        ];
    }

    protected function skater(array $stats): void
    {
        if (count($stats)) {
            $this->skaters[] = [
                'game_id'       => $this->game->id,
                'game_type_id'  => $this->game->game_type_id,
                'season_id'     => $this->game->season_id,
                'team_id'       => $this->teamId,
                'player_id'     => $this->playerId,
                'goals'         => _s($stats['goals'], 0),
                'assists'       => _s($stats['assists'], 0),
                'points'        => _s($stats['goals'], 0) + _s($stats['assists'], 0),
                'shots'         => _s($stats['shots'], 0),
                'hits'          => _s($stats['hits'], 0),
                'pp_goals'      => _s($stats['powerPlayGoals'], 0),
                'pp_assists'    => _s($stats['powerPlayAssists'], 0),
                'pp_points'     => _s($stats['powerPlayGoals'], 0) + _s($stats['powerPlayAssists'], 0),
                'pim'           => _s($stats['penaltyMinutes'], 0),
                'fo_wins'       => _s($stats['faceOffWins'], 0),
                'fo_taken'      => _s($stats['faceoffTaken'], 0),
                'takeaways'     => _s($stats['takeaways'], 0),
                'giveaways'     => _s($stats['giveaways'], 0),
                'sh_goals'      => _s($stats['shortHandedGoals'], 0),
                'sh_assists'    => _s($stats['shortHandedAssists'], 0),
                'sh_points'     => _s($stats['shortHandedGoals'], 0) + _s($stats['shortHandedAssists'], 0),
                'blocked_shots' => _s($stats['blocked'], 0),
                'plus_minus'    => _s($stats['plusMinus'], 0),
                'toi'           => _s($stats['timeOnIce'], 0),
                'ev_toi'        => _s($stats['evenTimeOnIce'], 0),
                'pp_toi'        => _s($stats['powerPlayTimeOnIce'], 0),
                'sh_toi'        => _s($stats['shortHandedTimeOnIce'], 0),
            ];
        } else {
            $this->statsNotFound();
        }
    }

    /*
        Found a few instances of gamelogs being incorrect for player stats. 
        As a workaround if stats is empty then fetch from this endpoint.
    */
    protected function statsNotFound(): void
    {
        $data = Http::get("https://statsapi.web.nhl.com/api/v1/people/{$this->playerId}/stats?stats=gameLog&season={$this->game->season_id}")->json();
        
        foreach ($data['stats'][0]['splits'] as $game) {
            if ($game['game']['gamePk'] === $this->game->id) {
                $this->skater($game['stat']);
                break;
            }
        }
    }
}