<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\BillItems;

class BillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $id = fake()->uuid();

            Bill::create([
                'id' => $id,
                'created_by' => \App\Models\User::all()->random()->id,
                'number' => \App\Models\Bill::getBillNumber(),
                'vendor_id' => \App\Models\Vendor::all()->random()->id,
                'status' => fake()->randomElement(['draft', 'paid', 'overdue', 'cancelled', 'unpaid']),
                'date' => now(),
                'due_date' => now()->addDays(15),
                'discount' => 0,
                'total' => 0,
            ]);

            for ($j = 0; $j < fake()->numberBetween(0, 15); $j++) {
                $item = \App\Models\Product::all()->random();
                $item_price = $item->buy_price;
                $item_quantity = fake()->numberBetween(1, 10);
                $item_total = $item_price * $item_quantity;

                BillItems::create([
                    'id' => fake()->uuid(),
                    'bill_id' => $id,
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'description' => fake()->sentence(),
                    'quantity' => $item_quantity,
                    'price' => $item_price,
                    'unit' => $item->unit,
                    'total' => $item_total,
                ]);

                $bill_items = BillItems::where('bill_id', $id)->get();
                $bill_total = 0;

                foreach ($bill_items as $item) {
                    $bill_total += $item->total;
                }

                Bill::where('id', $id)->update([
                    'total' => $bill_total,
                ]);
            }
        }
    }
}
