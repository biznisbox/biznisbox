<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $id = fake()->uuid();
            $type = fake()->randomElement(['bank_account', 'online_account', 'cash']);
            \App\Models\Account::create([
                'id' => $id,
                'name' => 'Account ' . $i,
                'description' => fake()->text(200),
                'opening_balance' => fake()->randomFloat(2, 1000, 5000),
                'date_opened' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'type' => $type,
                'currency' => \App\Models\Currency::all()->random()->code,
                'iban' => $type === 'bank_account' ? fake()->iban() : null,
                'bic' => $type === 'bank_account' ? fake()->swiftBicNumber() : null,
                'bank_name' => $type === 'bank_account' ? fake()->company() : null,
                'bank_address' =>
                    $type === 'bank_account' ? fake()->streetAddress() . ', ' . fake()->city() . ', ' . fake()->postcode() : null,
                'bank_contact' => $type === 'bank_account' ? fake()->name() : null,
                'is_default' => $i === 0,
                'is_active' => true,
            ]);
        }
    }
}
