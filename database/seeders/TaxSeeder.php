<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxes = [
            ['id' => fake()->uuid(), 'name' => '0%', 'rate' => 0, 'description' => fake()->text(200), 'active' => true],
            ['id' => fake()->uuid(), 'name' => '9.5%', 'rate' => 9.5, 'description' => fake()->text(200), 'active' => true],
            ['id' => fake()->uuid(), 'name' => '22%', 'rate' => 22, 'description' => fake()->text(200), 'active' => true],
            ['id' => fake()->uuid(), 'name' => '25%', 'rate' => 25, 'description' => fake()->text(200), 'active' => true],
            ['id' => fake()->uuid(), 'name' => '30%', 'rate' => 30, 'description' => fake()->text(200), 'active' => true],
            ['id' => fake()->uuid(), 'name' => '33%', 'rate' => 33, 'description' => fake()->text(200), 'active' => true],
            ['id' => fake()->uuid(), 'name' => '50%', 'rate' => 50, 'description' => fake()->text(200), 'active' => true],
        ];
        foreach ($taxes as $tax) {
            \App\Models\Tax::create($tax);
        }
    }
}
