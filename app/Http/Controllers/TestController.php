<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Years;
use App\Services\ScheduleService;

class TestController extends Controller
{
    public function index(ScheduleService $schedule)
    {
        $schedule->fetch(Years::search(2018));
    }
}
