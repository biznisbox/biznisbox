<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Bill;
use App\Models\Quote;
use App\Models\Session;
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
        $invoices = new Invoice();
        $invoices = $invoices->updateInvoiceStatusCron();
        $this->info('Invoice statuses updated successfully');

        // Update contract statuses
        $this->warn('Contract');
        $contracts = new Contract();
        $contracts = $contracts->updateContractStatusCron();
        $this->info('Contract statuses updated successfully');

        // Update bill statuses
        $this->warn('Bill');
        $bills = new Bill();
        $bills = $bills->updateBillStatusCron();
        $this->info('Bill statuses updated successfully');

        // Update Quote statuses
        $this->warn('Quote');
        $quotes = new Quote();
        $quotes = $quotes->updateQuoteStatusCron();
        $this->info('Quote statuses updated successfully');

        // Update session statuses
        $this->warn('Session');
        $sessions = new Session();
        $sessions = $sessions->updateSessionStatusCron();
        $this->info('Session statuses updated successfully');

        $this->alert('Statuses updated successfully');
    }
}
