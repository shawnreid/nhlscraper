<?php

namespace App\Models\Games;

use App\Jobs\GameJob;
use App\Models\Teams;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Games extends Model
{
    use HasFactory;

    protected $table = 'games';
    protected $fillable = [
        'id',
        'date',
        'game_type_id',
        'home_id',
        'away_id',
        'home_score',
        'away_score',
        'status'
    ];
    public $timestamps = false;
    public $incrementing = false;

    /**
     * Import all games
     *
     * @param  bool $overwrite
     * @return void
    */

    public static function importAllGames(bool $overwrite = true): void
    {
        Games::query()
            ->excludeFutureGames()
            ->overWriteGames($overwrite)
            ->get()
            ->each(fn(Games $game) =>
                GameJob::dispatch($game)
            );
    }

    /**
     * Import a single game
     *
     * @param  int  $game
     * @param  bool $overwrite
     * @return void
    */

    public static function importGame(int $game, bool $overwrite = true): void
    {
        $game = self::query()
            ->overWriteGames($overwrite)
            ->findOrFail($game);

        GameJob::dispatch($game);
    }

    /**
     * Import a range of games
     *
     * @param  mixed $start
     * @param  mixed $end
     * @param  bool  $overwrite
     * @return void
    */

    public static function importGames(mixed $start, mixed $end, bool $overwrite = true): void
    {
        self::query()
            ->overWriteGames($overwrite)
            ->gamesBetween($start, $end)
            ->get()
            ->each(fn(Games $game) =>
                GameJob::dispatch($game)
            );
    }

    /**
     * Import all games from a season
     *
     * @param  int  $season
     * @param  bool $overwrite
     * @return void
    */

    public static function importSeason(int $season, bool $overwrite = true): void
    {
        self::query()
            ->overWriteGames($overwrite)
            ->excludeFutureGames()
            ->whereSeasonId($season)
            ->get()
            ->each(fn(Games $game) =>
                GameJob::dispatch($game)
            );
    }

    /**
     * Import all games from a range of seasons
     *
     * @param  mixed $start
     * @param  mixed $end
     * @param  bool  $overwrite
     * @return void
    */

    public static function importSeasons(mixed $start, mixed $end, bool $overwrite = true): void
    {
        self::query()
            ->overWriteGames($overwrite)
            ->excludeFutureGames()
            ->seasonBetween($start, $end)
            ->get()
            ->each(fn(Games $game) =>
                GameJob::dispatch($game)
            );
    }

    /**
     * Return home team information
     *
     * @return HasOne
    */

    public function home(): HasOne
    {
        return $this->hasOne(Teams::class, 'id', 'home_id');
    }

    /**
     * Return away team information
     *
     * @return HasOne
    */

    public function away(): HasOne
    {
        return $this->hasOne(Teams::class, 'id', 'away_id');
    }

    /**
     * Scope to exclude games which have not yet occured
     *
     * @param Builder $query
     * @return Builder
    */

    public function scopeExcludeFutureGames(Builder $query): Builder
    {
        return $query->where('date', '<=', date('Y-m-d'));
    }

    /**
     * Scope to allow overwrites or not
     *
     * @param Builder $query
     * @param bool    $overwrite
     * @return Builder
    */

    public function scopeOverWriteGames(Builder $query, bool $overwrite): Builder
    {
        return $query->when(
            !$overwrite,
            fn($q) => $q->where('imported', 0)
        );
    }

    /**
     * Scope to return all games in a range of seasons
     *
     * @param Builder $query
     * @param int     $start
     * @param int     $end
     * @return Builder
    */

    public function scopeSeasonBetween(Builder $query, int $start, int $end): Builder
    {
        return $query->where('season_id', '>=', $start)
                     ->where('season_id', '<=', $end);
    }

    /**
     * Scope to return all games in a range
     *
     * @param Builder $query
     * @param int     $start
     * @param int     $end
     * @return Builder
    */

    public function scopeGamesBetween(Builder $query, int $start, int $end): Builder
    {
        return $query->where('id', '>=', $start)
                     ->where('id', '<=', $end);
    }
}
