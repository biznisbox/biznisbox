<?php

namespace App\Enum;

enum ConsoleCommandEnum: string
{
    case REFRESH_BANK_TRANSACTIONS = 'biznisbox:refresh-bank-transactions';
    case UPDATE_CURRENCY_RATE = 'biznisbox:update-currency-rate';
    case UPDATE_ITEM_STATUSES = 'biznisbox:update-item-statuses';
    case DEMO_RESET_DATA = 'app:demo-reset-data';

    public function description(): string
    {
        return match ($this) {
            self::REFRESH_BANK_TRANSACTIONS => 'Refresh bank transactions of all bank accounts in the system',
            self::UPDATE_CURRENCY_RATE => 'Update currency rate of all currencies in the system',
            self::UPDATE_ITEM_STATUSES => 'Update item statuses (invoices, contracts, etc.)',
            self::DEMO_RESET_DATA => 'Reset demo data to initial state',
        };
    }
}
