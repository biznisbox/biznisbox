<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $id = fake()->uuid();

            Vendor::create([
                'id' => $id,
                'name' => fake()->company(),
                'type' => fake()->randomElement(['individual', 'company']),
                'email' => fake()
                    ->unique()
                    ->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'city' => fake()->city(),
                'vat_number' => fake()->numberBetween(10000000000, 99999999999),
                'zip_code' => fake()->postcode(),
                'country' => fake()->country(),
                'currency' => 'EUR',
                'website' => fake()->url(),
            ]);
        }
    }
}
