<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        $schedule->command('books:get-list')
            ->name('get-booklist')
            ->onSuccess(function () {
                Log::info('get list success');
            })
            ->onFailure(function () {
                Log::error('GET LIST FAILED; RUNNING FROM SHELL');
                shell_exec('php artisan books:get-list');
            })
            ->hourlyAt(15);
        $schedule->command('books:get-files')
            ->name('get-body-files')
            ->onSuccess(function () {
                Log::info('get body success');
            })
            ->onFailure(function () {
                Log::error('GET BODY FAILED; RUNNING FROM SHELL');
                shell_exec('php artisan books:get-files');
            })
            ->hourlyAt(30);
        $schedule->command('comments:all-comments-by-mapping')
            ->name('get-comments')
            ->onSuccess(function () {
                Log::info('get comments success');
            })
            ->onFailure(function () {
                Log::error('GET COMMENTS FAILED; RUNNING FROM SHELL');
                shell_exec('php artisan comments:all-comments-by-mapping');
            })
            ->hourlyAt(45);

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
