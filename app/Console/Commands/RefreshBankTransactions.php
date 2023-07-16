<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenBankingService;

class RefreshBankTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biznisbox:refresh-bank-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh bank transactions from Open Banking API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing bank transactions...');

        $openBankingService = new OpenBankingService();
        $openBanking = $openBankingService->refreshBankTransactions();

        if ($openBanking) {
            $this->info('Bank transactions refreshed!');
            Command::SUCCESS;
        } else {
            $this->error('Bank transactions not refreshed!');
            Command::FAILURE;
        }
    }
}
