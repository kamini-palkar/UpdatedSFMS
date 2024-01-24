<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\EmailCron::class,
        Commands\weeklyEmailCron::class,
        Commands\DailyEmailCron::class,
    ];
    protected function schedule(Schedule $schedule): void
    {

        $schedule->command('email:cron')->everyMinute();
        $schedule->command('weeklyEmailCorn:cron')->everyMinute();
        $schedule->command('DailyEmailCorn:cron')->everyMinute();


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
