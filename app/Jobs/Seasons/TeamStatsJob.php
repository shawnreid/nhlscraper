<?php

namespace App\Jobs\Seasons;

use App\Services\Seasons\TeamStatsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TeamStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(TeamStatsService $stats): void
    {
        $stats->save();
    }
}