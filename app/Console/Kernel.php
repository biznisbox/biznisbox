<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Stringable;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\ScheduleRuns;

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
        // Schedule the update currency rates command to run daily
        $schedule
            ->command('biznisbox:update-currency-rates')
            ->daily()
            ->withoutOverlapping()
            ->onSuccess(function (Stringable $output) {
                ScheduleRuns::createTask('biznisbox:update-currency-rates', 'success', $output);
            })
            ->onFailure(function (Stringable $output) {
                ScheduleRuns::createTask('biznisbox:update-currency-rates', 'failed', $output);
            });

        // Schedule the refresh bank transactions command to run hourly
        $schedule
            ->command('biznisbox:refresh-bank-transactions')
            ->hourly()
            ->withoutOverlapping()
            ->onSuccess(function (Stringable $output) {
                ScheduleRuns::createTask('biznisbox:refresh-bank-transactions', 'success', $output);
            })
            ->onFailure(function (Stringable $output) {
                ScheduleRuns::createTask('biznisbox:refresh-bank-transactions', 'failed', $output);
            });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
