<?php

namespace App\Console;

use App\Console\Commands\FindSuspiciousWorklogs;
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
        Commands\SendYesterdaySql::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command(FindUnassignedProjects::class)->timezone('Europe/Berlin')->weekdays()->dailyAt('16:30');

        $schedule->command(FindUnfinishedWorklogs::class)->timezone('Europe/Berlin')->weekdays()->dailyAt('16:40');
        $schedule->command(FindSuspiciousWorklogs::class)->timezone('Europe/Berlin')->weekdays()->dailyAt('16:50');

        $schedule->command(FindUnexportedWorklogs::class)->timezone('Europe/Berlin')->weekdays()->daily();
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
