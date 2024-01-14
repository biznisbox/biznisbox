<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $id = fake()->uuid();
            \App\Models\Employee::create([
                'id' => $id,
                'user_id' => \App\Models\User::all()->random()->id,
                'department_id' => \App\Models\Department::all()->random()->id,
                'number' => \App\Models\Employee::getEmployeeNumber(),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->email(),
                'phone_number' => fake()->phoneNumber(),
                'description' => fake()->text(200),
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'zip_code' => fake()->postcode(),
                'country' => fake()->country(),
                'position' => fake()->jobTitle(),
                'type' => fake()->randomElement(['full_time', 'part_time', 'intern', 'contractor', 'founder']),
                'salary' => fake()->randomFloat(2, 1000, 10000),
                'hourly_rate' => fake()->randomFloat(2, 10, 100),
                'level' => fake()->randomElement(['junior', 'mid_level', 'senior', 'director', 'owner']),
                'contract_type' => fake()->randomElement(['permanent', 'temporary', 'contractor', 'intern']),
                'contract_start_date' => fake()->dateTimeBetween('-5 years', 'now'),
                'contract_end_date' => fake()->dateTimeBetween('now', '+5 years'),
            ]);
            incrementLastItemNumber('employee');
        }
    }
}
