<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       

        // $schedule->command('inspire')->hourly();
        $schedule->command('remove:cron')->everyMinute();
        $schedule->command('plan:cancel_plan')->everyMinute();
        $schedule->command('countrynotus:cron')->everyMinute();
        // $schedule->call(function () {
        //     Artisan::call('plan:cancel_plan');
        // })->dailyAt('22:23');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
