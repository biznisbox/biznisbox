<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            ProductsSeeder::class,
            InvoiceSeeder::class,
            EstimateSeeder::class,
            AccountsSeeder::class,
            TransactionSeeder::class,
            VendorsSeeder::class,
            BillsSeeder::class,
            CalendarSeeder::class,
        ]);
    }
}
