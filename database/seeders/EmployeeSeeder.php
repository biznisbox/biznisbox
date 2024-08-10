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
            $user = \App\Models\User::all()->random();
            \App\Models\Employee::create([
                'id' => fake()->uuid(),
                'user_id' => $user->id,
                'number' => \App\Models\Employee::getEmployeeNumber(),
                'department_id' => \App\Models\Department::all()->random()->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => fake()->phoneNumber(),
                'description' => fake()->text(200),
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'zip_code' => fake()->postcode(),
                'country' => fake()->country(),
                'position' => fake()->jobTitle(),
                'status' => fake()->randomElement(['active', 'inactive']),
                'type' => fake()->randomElement(['full_time', 'part_time', 'contractor']),
                'salary' => fake()->randomFloat(2, 1000, 5000),
                'hourly_rate' => fake()->randomFloat(2, 10, 50),
                'level' => fake()->randomElement(['junior', 'senior']),
                'contract_type' => fake()->randomElement(['permanent', 'temporary']),
                'contract_start_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'contract_end_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            ]);

            incrementLastItemNumber('employee');
        }
    }
}
