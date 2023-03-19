<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currencies;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'biznisbox:update-currency-rates';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Update currency rates';

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $this->info('Updating currency rates...');
        $currencies = new Currencies();
        $currencies->liveUpdateCurrencyRate();
        if (!settings('default_currency') == 'EUR') {
            $this->error('Default currency is not set to EUR!');
            return Command::FAILURE;
        }
        $this->info('Currency rates updated successfully!');
        return Command::SUCCESS;
    }
}
