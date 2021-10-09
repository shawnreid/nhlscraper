<?php

namespace App\Services;

use App\Models\Schedule;
use App\Services\Game\BoxScoreService;
use App\Services\Game\TimelineService;
use App\Services\Game\TeamStatsService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GameService
{
    public function __construct(
        protected TeamStatsService $team,
        protected BoxScoreService $boxscore,
        protected TimelineService $timeline
    ) { }

    public function fetch(Schedule $schedule): void
    {
        $data = Http::get(
            Str::replace(
                '{gameid}', 
                (string) $schedule->id, 
                \config('scraper.endpoints.game')
            )
        )->json();

        $this->timeline->save($schedule->id, $data['liveData']['plays']['allPlays']);
        $this->boxscore->save($schedule->id, $data['liveData']['boxscore']);
        $this->team->save($schedule->id);
    }
}