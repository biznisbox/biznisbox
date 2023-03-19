<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estimate;

class EstimateSeeder extends Seeder
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

            $customer = \App\Models\Customer::all()->random();
            $customer_address = $customer->addresses->where('type', 'billing')->first();

            $payer = \App\Models\Customer::all()->random();
            $payer_address = $payer->addresses->where('type', 'billing')->first();

            Estimate::create([
                'id' => $id,
                'created_by' => \App\Models\User::all()->random()->id,
                'number' => \App\Models\Estimate::getEstimateNumber(),
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_address' => $customer_address->address,
                'customer_city' => $customer_address->city,
                'customer_zip_code' => $customer_address->zip_code,
                'customer_country' => $customer_address->country,
                'payer_id' => $payer->id,
                'payer_name' => $payer->name,
                'payer_address' => $payer_address->address,
                'payer_city' => $payer_address->city,
                'payer_zip_code' => $payer_address->zip_code,
                'payer_country' => $payer_address->country,
                'status' => fake()->randomElement(['draft', 'sent', 'accepted', 'rejected', 'expired']),
                'currency' => 'EUR',
                'date' => now(),
                'valid_until' => now()->addDays(15),
                'discount' => 0,
                'tax' => 0,
                'total' => 0,
            ]);

            for ($j = 0; $j < fake()->numberBetween(0, 15); $j++) {
                $item = \App\Models\Product::all()->random();
                $item_price = $item->sell_price;
                $item_discount = fake()->numberBetween(0, 60);
                $item_quality = fake()->numberBetween(1, 10);
                $item_total = $item_price * $item_quality;
                $item_total = $item_total - ($item_total * $item_discount) / 100;

                \App\Models\EstimateItems::create([
                    'id' => fake()->uuid(),
                    'estimate_id' => $id,
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'description' => fake()->sentence(),
                    'quantity' => $item_quality,
                    'price' => $item_price,
                    'unit' => $item->unit,
                    'discount' => $item_discount,
                    'tax' => 0,
                    'total' => $item_total,
                ]);

                $estimate_items = \App\Models\EstimateItems::where('estimate_id', $id)->get();

                $estimate_total = 0;
                foreach ($estimate_items as $item) {
                    $estimate_total += $item->total;
                }

                Estimate::where('id', $id)->update([
                    'total' => $estimate_total,
                ]);

                incrementLastItemNumber('estimate');
            }
        }
    }
}
