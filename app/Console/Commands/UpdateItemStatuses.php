<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Bill;
use App\Models\Quote;
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
        // Update invoice statuses
        $this->info('Updating invoice statuses...');
        $invoices = new Invoice();
        $invoices = $invoices->updateInvoiceStatusCron();
        $this->info('Invoice statuses updated successfully');

        // Update contract statuses
        $this->info('Updating contract statuses...');
        $contracts = new Contract();
        $contracts = $contracts->updateContractStatusCron();
        $this->info('Contract statuses updated successfully');

        // Update bill statuses
        $this->info('Updating bill statuses...');
        $bills = new Bill();
        $bills = $bills->updateBillStatusCron();
        $this->info('Bill statuses updated successfully');

        // Update Quote statuses
        $this->info('Updating Quote statuses...');
        $quotes = new Quote();
        $quotes = $quotes->updateQuoteStatusCron();
        $this->info('Quote statuses updated successfully');

        $this->success('Statuses updated successfully');
    }
}
