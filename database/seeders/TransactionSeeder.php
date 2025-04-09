<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 1000; $i++) {
            $id = fake()->uuid();
            $type = fake()->randomElement(['income', 'expense', 'transfer']);
            $from_account = null;
            $to_account = null;
            $invoice_id = null;
            $bill_id = null;
            $customer_id = null;
            $supplier_id = null;
            $payment_method = \App\Models\Category::where('module', 'payment_method')->get()->random();

            if ($type === 'transfer') {
                $from_account = \App\Models\Account::all()->random()->id;
                $to_account = \App\Models\Account::all()->random()->id;
            }

            if ($type === 'income') {
                $invoice_id = \App\Models\Invoice::all()->random()->id;
                $bill_id = null;
                $customer_id = \App\Models\Invoice::find($invoice_id)->customer_id;
            }

            if ($type === 'expense') {
                $invoice_id = null;
                $bill_id = \App\Models\Bill::all()->random()->id;
                $supplier_id = \App\Models\Bill::find($bill_id)->supplier_id;
            }

            \App\Models\Transaction::create([
                'id' => $id,
                'account_id' => \App\Models\Account::all()->random()->id,
                'from_account' => $from_account,
                'to_account' => $to_account,
                'invoice_id' => $invoice_id,
                'bill_id' => $bill_id,
                'customer_id' => $customer_id,
                'supplier_id' => $supplier_id,
                'number' => \App\Models\Transaction::getTransactionNumber(),
                'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'type' => $type,
                'name' => fake()->sentence(),
                'description' => fake()->text(200),
                'amount' => fake()->randomFloat(2, 1, 1000),
                'currency' => settings('default_currency'),
                'exchange_rate' => 1,
                'payment_method_id' => $payment_method->id,
                'status' => fake()->randomElement(['draft', 'completed', 'reconciled']),
                'reconciled' => false,
            ]);
            incrementLastItemNumber('transaction');
        }
    }
}
