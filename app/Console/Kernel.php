<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            error_log(shell_exec('php artisan books:get-list'));
        })->hourlyAt(15);

        $schedule->call(function(){
            error_log(shell_exec('php artisan books:get-files'));
        })->hourlyAt(30);

        $schedule->call(function(){
            error_log(shell_exec('php artisan comments:all-comments-by-mapping'));
        })->hourlyAt(45);

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
