<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::command('biznisbox:refresh-bank-transactions')
    ->withoutOverlapping()
    ->hourly()
    ->onSuccess(function () {
        Log::info('Bank transactions refreshed successfully');
    })
    ->onFailure(function () {
        Log::error('Failed to refresh bank transactions');
    });

Schedule::command('biznisbox:update-currency-rate')
    ->withoutOverlapping()
    ->daily()
    ->onSuccess(function () {
        Log::info('Currency rate updated successfully');
    })
    ->onFailure(function () {
        Log::error('Failed to update currency rate');
    });
