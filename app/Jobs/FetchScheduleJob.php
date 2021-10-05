<?php

namespace App\Jobs;

use App\Models\Years;
use App\Services\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Years $year) { }

    public function handle(Schedule $schedule): void
    {
        $schedule->fetch($this->year);
    }
}
