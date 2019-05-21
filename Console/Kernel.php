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
        //dd($schedule->objectIdentitifier);
         $schedule->command('inspire')->cron('*/1 * * * * *')->sendOutputTo(storage_path('logs/output.log'));
       //  $schedule->command('aspire')->everyMinute()->sendOutputTo(storage_path("logs/output.log"));
        // Here The Command Calls the console.php in routes folder and from there it calls further
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
