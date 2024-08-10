<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;

class UpdateCurrencyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biznisbox:update-currency-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency rate of all currencies in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currency = new Currency();
        $result = $currency->liveUpdateCurrencyRate();
        if ($result['status']) {
            $this->info($result['message']);
        } else {
            $this->error($result['message']);
        }
    }
}
