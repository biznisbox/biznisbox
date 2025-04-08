<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $id = fake()->uuid();
            $supplier = \App\Models\Partner::where('type', 'supplier')->orWhere('type', 'both')->get()->random();
            $supplier_address = $supplier->addresses->random();
            $payment_method = \App\Models\Category::where('module', 'payment_method')->get()->random();
            $discount = fake()->randomFloat(2, 0, 100);
            \App\Models\Bill::create([
                'id' => $id,
                'number' => \App\Models\Bill::getBillNumber(),
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->name,
                'supplier_address' => $supplier_address->address,
                'supplier_city' => $supplier_address->city,
                'supplier_zip_code' => $supplier_address->zip_code,
                'supplier_country' => $supplier_address->country,
                'supplier_address_id' => $supplier_address->id,
                'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'due_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'status' => fake()->randomElement(['draft', 'paid', 'cancelled', 'overdue', 'refunded', 'unpaid']),
                'currency' => settings('default_currency'),
                'currency_rate' => 1,
                'notes' => fake()->text(200),
                'footer' => fake()->text(200),
                'discount' => $discount,
                'payment_method_id' => $payment_method->id,
                'discount_type' => 'percent',
                'total' => 0,
            ]);

            $total = 0;
            for ($j = 0; $j < fake()->numberBetween(1, 10); $j++) {
                $quantity = fake()->numberBetween(1, 10);
                $discount = fake()->randomFloat(2, 0, 50);
                $product = \App\Models\Product::all()->random();
                $total += $quantity * $product->sell_price - ($quantity * $product->sell_price * $discount) / 100;
                \App\Models\BillItem::create([
                    'id' => fake()->uuid(),
                    'product_id' => $product->id,
                    'bill_id' => $id,
                    'name' => $product->name,
                    'description' => fake()->text(200),
                    'quantity' => $quantity,
                    'unit' => $product->unit,
                    'price' => $product->sell_price,
                    'discount' => $discount,
                    'discount_type' => 'percent',
                    'total' => $quantity * $product->sell_price - ($quantity * $product->sell_price * $discount) / 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $invoice = \App\Models\Bill::find($id);
            $invoice->total = $total - ($total * $discount) / 100;
            $invoice->save();

            incrementLastItemNumber('bill');
        }
    }
}
