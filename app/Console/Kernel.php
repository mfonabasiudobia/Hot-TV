<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Spatie\ShortSchedule\ShortSchedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\TvChannelCron::class,
    ];

    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule): void
    // {
    //     $schedule->command('app:tv-channel')->everySecond();
    // }

    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule)
    {
        // this command will run every second
        $shortSchedule->command('app:tv-channel')->everySecond(3);
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
