<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $tax_value = fake()->randomFloat(2, 1, 100);
            \App\Models\Taxes::create([
                'name' => 'Tax ' . $tax_value . '%',
                'value' => fake()->randomFloat(2, 1, 100),
                'type' => fake()->randomElement(['percentage', 'fixed']),
                'description' => fake()->sentence(),
                'is_active' => true,
            ]);
        }
    }
}
