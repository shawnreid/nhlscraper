<?php

namespace App\Models\Games;

use App\Jobs\GameJob;
use App\Models\Teams;
use App\Traits\OverWriteDataScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Games extends Model
{
    use HasFactory, OverWriteDataScope;

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
            ->overWriteData($overwrite)
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
            ->overWriteData($overwrite)
            ->find($game);

        if ($game) {
            GameJob::dispatch($game);
        }
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
            ->overWriteData($overwrite)
            ->whereBetween('id', [$start, $end])
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
            ->overWriteData($overwrite)
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
            ->overWriteData($overwrite)
            ->excludeFutureGames()
            ->whereBetween('season_id', [$start, $end])
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
}
