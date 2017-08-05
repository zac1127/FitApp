<?php

namespace App\Console;

use App\Week;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $number_of_weeks = Week::all()->count() + 1;
            $date = Carbon::today()->format('n-d-Y');
            $week = new Week();
            $week->week_number = $number_of_weeks;
            $week->date = $date;
            $week->save();
            // 2 = tuesday at 0:00 midnight
        })->weeklyOn(1, '23:58');
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
