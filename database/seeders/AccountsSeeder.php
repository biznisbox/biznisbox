<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accounts;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $id = fake()->uuid();

            $balance = fake()->randomFloat(2, 1, 1000);
            Accounts::create([
                'id' => $id,
                'name' => 'Account ' . fake()->randomElement(['A', 'B', 'C', 'D', 'E']),
                'description' => fake()->sentence(),
                'currency' => 'EUR',
                'type' => fake()->randomElement(['bank_account', 'cash', 'credit_card', 'online_account']),
                'opening_balance' => $balance,
                'current_balance' => $balance,
                'bank_name' => fake()->company(),
                'bank_address' => fake()->address(),
                'bank_contact' => fake()->phoneNumber(),
                'iban' => fake()->iban(),
                'bic' => fake()->swiftBicNumber(),
            ]);
        }
    }
}
