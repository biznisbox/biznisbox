<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $date = Carbon::now();
            $date = $date->addWeeks(rand(1, 52))->format('Y-m-d');
            Transaction::create([
                'id' => fake()->uuid(),
                'name' => 'Transaction ' . fake()->numberBetween(100000, 999999),
                'number' => \App\Models\Transaction::getTransactionNumber(),
                'date' => Carbon::createFromFormat('Y-m-d', $date)->timestamp,
                'type' => fake()->randomElement(['income', 'expense']),
                'description' => fake()->sentence(),
                'amount' => fake()->randomFloat(2, 1, 100),
                'currency' => 'EUR',
                'created_by' => \App\Models\User::all()->random()->id,
                'account_id' => \App\Models\Accounts::all()->random()->id,
            ]);
            incrementLastItemNumber('transaction');
        }
    }
}
