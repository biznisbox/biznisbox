<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Bill;
use App\Models\Quote;
use App\Models\Session;
use App\Services\OnlinePaymentService;
use Illuminate\Console\Command;

class UpdateItemStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biznisbox:update-item-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update item statuses (invoices, contracts, etc.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update statuses
        $this->alert('Updating statuses');

        // Update invoice statuses
        $this->warn('Invoice');
        Invoice::updateInvoiceStatusCron();
        $this->info('Invoice statuses updated successfully');

        // Update contract statuses
        $this->warn('Contract');
        Contract::updateContractStatusCron();
        $this->info('Contract statuses updated successfully');

        // Update bill statuses
        $this->warn('Bill');
        Bill::updateBillStatusCron();
        $this->info('Bill statuses updated successfully');

        // Update Quote statuses
        $this->warn('Quote');
        Quote::updateQuoteStatusCron();
        $this->info('Quote statuses updated successfully');

        // Update session statuses
        $this->warn('Session');
        Session::updateSessionStatusCron();
        $this->info('Session statuses updated successfully');

        // Check and update all Coinbase payment statuses
        $this->warn('Coinbase');
        OnlinePaymentService::checkAllCoinbasePaymentStatus();
        $this->info('Coinbase payment statuses updated successfully');

        $this->alert('Statuses updated successfully');
    }
}
