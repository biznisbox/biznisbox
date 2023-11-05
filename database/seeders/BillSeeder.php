<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\BillItems;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $id = fake()->uuid();
            Bill::create([
                'id' => $id,
                'number' => Bill::getBillNumber(),
                'status' => fake()->randomElement(['draft', 'sent', 'paid', 'cancelled']),
                'date' => fake()->dateTimeBetween('-1 years', 'now'),
                'due_date' => fake()->dateTimeBetween('-1 years', 'now'),
                'notes' => fake()->text(200),
                'footer' => fake()->text(200),
                'currency' => fake()->randomElement(['EUR', 'USD']),
                'discount' => fake()->randomFloat(2, 0, 100),
            ]);

            for ($j = 0; $j < 3; $j++) {
                $product = \App\Models\Product::where('buy_price', '>', 0)
                    ->get()
                    ->random();
                $quality = fake()->numberBetween(1, 10);
                $discount = fake()->randomFloat(2, 0, 100);
                BillItems::create([
                    'id' => fake()->uuid(),
                    'bill_id' => $id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'description' => fake()->sentence(),
                    'price' => $product->buy_price,
                    'quantity' => $quality,
                    'unit' => $product->unit,
                    'total' => $product->buy_price * $quality,
                ]);
            }

            // Calculate totals
            $bill = Bill::find($id);

            $items = BillItems::where('bill_id', $id)->get();
            $total = 0;
            foreach ($items as $item) {
                $total += $item->total;
            }
            $discount = $bill->discount;
            $bill->total = $total - $total * ($discount / 100);
            $bill->save();
            incrementLastItemNumber('bill');
        }
    }
}
