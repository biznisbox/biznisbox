<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = ['pcs', 'kg', 'm', 'l', 'm2', 'm3', 'hour', 'day', 'week', 'month', 'year', 'unit', 'ml'];
        for ($i = 0; $i < 20; $i++) {
            $productData = [
                'id' => fake()->uuid(),
                'name' => 'Product ' . fake()->numberBetween(100000, 999999),
                'description' => fake()->sentence(),
                'sell_price' => fake()->randomFloat(2, 1, 100),
                'buy_price' => fake()->randomFloat(2, 1, 100),
                'stock' => fake()->numberBetween(0, 1000),
                'unit' => fake()->randomElement($units),
                'stock_min' => fake()->numberBetween(0, 1000),
                'stock_max' => fake()->numberBetween(0, 1000),
                'tax' => 0,
                'type' => fake()->randomElement(['product', 'service']),
                'barcode' => fake()->ean13(),
            ];

            Product::create($productData);
        }
    }
}
