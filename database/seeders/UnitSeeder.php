<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'kilogram', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'kg'],
            ['name' => 'gram', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'g'],
            ['name' => 'mg', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'mg'],
            ['name' => 'tons', 'description' => fake()->text(200), 'active' => true, 'symbol' => 't'],
            ['name' => 'liter', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'l'],
            ['name' => 'milliliter', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'ml'],
            ['name' => 'meter', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'm'],
            ['name' => 'cm', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'cm'],
            ['name' => 'mm', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'mm'],
            ['name' => 'km', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'km'],
            ['name' => 'm²', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'm²'],
            ['name' => 'cm²', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'cm²'],
            ['name' => 'mm²', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'mm²'],
            ['name' => 'm³', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'm³'],
            ['name' => 'cm³', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'cm³'],
            ['name' => 'mm³', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'mm³'],
            ['name' => 'hour', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'h'],
            ['name' => 'minute', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'min'],
            ['name' => 'second', 'description' => fake()->text(200), 'active' => true, 'symbol' => 's'],
            ['name' => 'day', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'd'],
            ['name' => 'week', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'w'],
            ['name' => 'month', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'm'],
            ['name' => 'year', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'y'],
            ['name' => '°C', 'description' => fake()->text(200), 'active' => true, 'symbol' => '°C'],
            ['name' => '°F', 'description' => fake()->text(200), 'active' => true, 'symbol' => '°F'],
            ['name' => 'K', 'description' => fake()->text(200), 'active' => true, 'symbol' => 'K'],
        ];
        foreach ($units as $unit) {
            \App\Models\Unit::create($unit);
        }
    }
}
