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
            TaxesSeeder::class,
            ProductsSeeder::class,
            AccountsSeeder::class,
            CalendarSeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            PartnersSeeder::class,
            InvoiceSeeder::class,
            QuoteSeeder::class,
            BillSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
