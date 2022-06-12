<?php

namespace App\Jobs\Seasons;

use App\Services\Seasons\SkaterStatsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SkaterStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $queue = 'calculate'
    ) { }

    public function handle(SkaterStatsService $stats): void
    {
        $stats->save();
    }
}
