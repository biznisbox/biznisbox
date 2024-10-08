<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $id = fake()->uuid();
            \App\Models\Department::create([
                'id' => $id,
                'type' => fake()->randomElement(['office', 'warehouse', 'store', 'support', 'other']),
                'name' => fake()->jobTitle(),
                'description' => fake()->text(200),
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'zip_code' => fake()->postcode(),
                'country' => fake()->country(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->email(),
                'longitude' => fake()->longitude(),
                'latitude' => fake()->latitude(),
            ]);
        }
    }
}
