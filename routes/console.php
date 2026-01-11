<?php

use App\Enum\ConsoleCommandEnum;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Stringable;

Schedule::command(ConsoleCommandEnum::REFRESH_BANK_TRANSACTIONS->value)
    ->withoutOverlapping()
    ->hourly()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::REFRESH_BANK_TRANSACTIONS->value, 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::REFRESH_BANK_TRANSACTIONS->value, 'failed', $output);
    });

Schedule::command(ConsoleCommandEnum::SEND_SUPPORT_TICKET_IMAP_MAILER->value)
    ->withoutOverlapping()
    ->everyFiveMinutes()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::SEND_SUPPORT_TICKET_IMAP_MAILER->value, 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::SEND_SUPPORT_TICKET_IMAP_MAILER->value, 'failed', $output);
    });

Schedule::command(ConsoleCommandEnum::UPDATE_CURRENCY_RATE->value)
    ->withoutOverlapping()
    ->daily()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::UPDATE_CURRENCY_RATE->value, 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::UPDATE_CURRENCY_RATE->value, 'failed', $output);
    });

Schedule::command(ConsoleCommandEnum::UPDATE_ITEM_STATUSES->value)
    ->withoutOverlapping()
    ->daily()
    ->onSuccess(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::UPDATE_ITEM_STATUSES->value, 'success', $output);
    })
    ->onFailure(function (Stringable $output) {
        insertScheduleRun(ConsoleCommandEnum::UPDATE_ITEM_STATUSES->value, 'failed', $output);
    });

// Reset demo data
if (config('app.demo.enabled') === true) {
    Schedule::command(ConsoleCommandEnum::DEMO_RESET_DATA->value)
        ->withoutOverlapping()
        ->everySixHours()
        ->onSuccess(function (Stringable $output) {
            insertScheduleRun(ConsoleCommandEnum::DEMO_RESET_DATA->value, 'success', $output);
        })
        ->onFailure(function (Stringable $output) {
            insertScheduleRun(ConsoleCommandEnum::DEMO_RESET_DATA->value, 'failed', $output);
        });
}
