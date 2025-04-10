<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Stringable;

Schedule::command('biznisbox:refresh-bank-transactions')
    ->withoutOverlapping()
    ->hourly()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun('biznisbox:refresh-bank-transactions', 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun('biznisbox:refresh-bank-transactions', 'failed', $output);
    });

Schedule::command('biznisbox:update-currency-rate')
    ->withoutOverlapping()
    ->daily()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun('biznisbox:update-currency-rate', 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun('biznisbox:update-currency-rate', 'failed', $output);
    });

Schedule::command('biznisbox:update-item-statuses')
    ->withoutOverlapping()
    ->daily()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun('biznisbox:update-item-statuses', 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun('biznisbox:update-item-statuses', 'failed', $output);
    });


// Reset demo data
if(config('app.demo.enabled') === true)
{
    Schedule::command('app:demo-reset-data')
        ->withoutOverlapping()
        ->everySixHours()
        ->onSuccess(function (Stringable $output) {
            insertScheduleRun('app:demo-reset-data', 'success', $output);
        })
        ->onFailure(function (Stringable $output) {
            insertScheduleRun('app:demo-reset-data', 'failed', $output);
        });
}