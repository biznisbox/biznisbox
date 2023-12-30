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
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'id' => fake()->uuid(),
                'number' => Product::getProductNumber(),
                'name' => fake()->randomNumber(8),
                'description' => fake()->sentence(),
                'sell_price' => fake()->randomFloat(2, 1, 100),
                'buy_price' => fake()->randomFloat(2, 1, 100),
                'stock' => fake()->numberBetween(0, 1000),
                'unit' => \App\Models\Units::all()->random()->name,
                'stock_min' => fake()->numberBetween(0, 1000),
                'stock_max' => fake()->numberBetween(0, 1000),
                'tax' => \App\Models\Taxes::all()->random()->value,
                'type' => fake()->randomElement(['product', 'service']),
                'barcode' => fake()->ean13(),
            ]);
            incrementLastItemNumber('product');
        }
    }
}
