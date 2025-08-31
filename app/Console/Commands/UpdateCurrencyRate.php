<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;
use App\Services\Admin\CurrencyService;
use App\Integrations\ExchangeRate;

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
        $currencyService = new CurrencyService(new Currency(), new ExchangeRate());
        $result = $currencyService->liveUpdateCurrencyRate();
        if ($result['status']) {
            $this->info($result['message']);
        } else {
            $this->error($result['message']);
        }
    }
}
