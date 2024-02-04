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
            $supplier_id = \App\Models\Partner::where('type', 'supplier')->orWhere('type', 'both')->get()->random()->id;
            $supplier_data = \App\Models\Partner::find($supplier_id);
            $supplier_address_id = \App\Models\PartnerAddress::where('partner_id', $supplier_id)->get()->random()->id;
            $supplier_address_data = \App\Models\PartnerAddress::find($supplier_address_id);
            Bill::create([
                'id' => $id,
                'number' => Bill::getBillNumber(),
                'status' => fake()->randomElement(['draft', 'unpaid', 'paid', 'cancelled']),
                'date' => fake()->dateTimeBetween('-1 years', 'now'),
                'due_date' => fake()->dateTimeBetween('-1 years', 'now'),
                'notes' => fake()->text(200),
                'footer' => fake()->text(200),
                'currency' => fake()->randomElement(['EUR', 'USD', 'GBP']),
                'discount' => fake()->randomFloat(2, 0, 100),
                'total' => 0,
                'supplier_id' => $supplier_id,
                'supplier_name' => $supplier_data->name,
                'supplier_address_id' => $supplier_address_id,
                'supplier_address' => $supplier_address_data->address,
                'supplier_city' => $supplier_address_data->city,
                'supplier_zip_code' => $supplier_address_data->zip,
                'supplier_country' => $supplier_address_data->country,
                'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'check', 'stripe', 'paypal']),
            ]);

            for ($j = 0; $j < 3; $j++) {
                $product = \App\Models\Product::where('buy_price', '>', 0)->get()->random();
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
