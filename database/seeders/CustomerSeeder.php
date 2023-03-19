<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {
            $id = fake()->uuid();
            Customer::create([
                'id' => $id,
                'name' => fake()->company() . ' ' . fake()->companySuffix(),
                'type' => fake()->randomElement(['individual', 'company']),
                'vat_number' => fake()->numberBetween(100000000, 999999999),
                'language' => 'en',
                'notes' => fake()->text(),
                'website' => fake()->url(),
                'email' => fake()
                    ->unique()
                    ->safeEmail(),
                'phone' => fake()->phoneNumber(),
            ]);

            CustomerAddress::create([
                'id' => fake()->uuid(),
                'customer_id' => $id,
                'type' => 'billing',
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'zip_code' => fake()->postcode(),
                'country' => fake()->country(),
                'notes' => fake()->text(),
            ]);

            CustomerAddress::create([
                'id' => fake()->uuid(),
                'customer_id' => $id,
                'type' => 'shipping',
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'zip_code' => fake()->postcode(),
                'country' => fake()->country(),
                'notes' => fake()->text(),
            ]);
        }
    }
}
