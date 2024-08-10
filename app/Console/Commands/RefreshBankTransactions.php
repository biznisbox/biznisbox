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
    protected $description = 'Refresh bank transactions of all bank accounts in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $openBankingService = new OpenBankingService();
        $result = $openBankingService->refreshBankTransactions();
        if ($result) {
            $this->info('Bank transactions refreshed successfully');
        } else {
            $this->error('Failed to refresh bank transactions');
        }
    }
}
