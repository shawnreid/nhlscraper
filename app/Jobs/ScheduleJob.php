<?php

namespace App\Jobs;

use App\Models\Seasons\Seasons;
use App\Services\Game\ScheduleService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Seasons $season,
        public $queue = 'schedule'
    ) { }

    public function handle(ScheduleService $schedule): void
    {
        $schedule->fetch($this->season);
    }
}
