<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;
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
        \App\Console\Commands\CheckDeadlines::class,
        \App\Console\Commands\SendDeadlineNotifications::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

        // Lock old tasks daily
        $schedule->command('app:lock-all-old-tasks')
            // ->dailyAt('00:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Check deadlines at midnight
        $schedule->command('app:check-deadlines')
            // ->dailyAt('00:00')
            ->withoutOverlapping()
            ->runInBackground();


        // Send deadline notifications in the morning
        $schedule->command('app:send-deadline-notification')
            // ->dailyAt('00:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Optional: Log scheduling attempts
        // $schedule->command('app:check-deadlines')
        //     ->onFailure(function () {
        //         Log::error('Deadline check command failed');
        //     });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
