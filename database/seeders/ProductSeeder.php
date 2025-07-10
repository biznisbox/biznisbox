<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $id = fake()->uuid();
            $type = fake()->randomElement(['product', 'service']);
            \App\Models\Product::create([
                'id' => $id,
                'number' => \App\Models\Product::getProductNumber(),
                'name' => fake()->company(),
                'description' => fake()->text(200),
                'type' => $type,
                'unit' => \App\Models\Unit::all()->random()->value('name'),
                'tax' => \App\Models\Tax::all()->random()->value('rate'),
                'buy_price' => fake()->randomFloat(2, 1, 1000),
                'sell_price' => fake()->randomFloat(2, 1, 1000),
                'stock' => $type === 'product' ? fake()->numberBetween(1, 1000) : null,
                'stock_min' => $type === 'product' ? fake()->numberBetween(1, 100) : null,
                'stock_max' => $type === 'product' ? fake()->numberBetween(100, 1000) : null,
                'barcode' => fake()->ean13(),
                'active' => fake()->boolean(),
            ]);
            incrementLastItemNumber('product', settings('product_number_format'));
        }
    }
}
