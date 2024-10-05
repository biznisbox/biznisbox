<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            TaxSeeder::class,
            UnitSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            PartnerSeeder::class,
            ProductSeeder::class,
            EmployeeSeeder::class,
            AccountSeeder::class,
            InvoiceSeeder::class,
            QuoteSeeder::class,
            BillSeeder::class,
            TransactionSeeder::class,
            ContractSeeder::class,
        ]);
    }
}
