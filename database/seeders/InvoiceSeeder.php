<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvoiceItems;

class InvoiceSeeder extends Seeder
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

            Invoice::create([
                'id' => $id,
                'created_by' => \App\Models\User::all()->random()->id,
                'number' => \App\Models\Invoice::getInvoiceNumber(),
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
                'status' => fake()->randomElement(['draft', 'sent', 'paid', 'overdue', 'cancelled', 'refunded']),
                'currency' => 'EUR',
                'date' => now(),
                'due_date' => now()->addDays(15),
                'discount' => 0,
                'tax' => 0,
                'total' => 0,
            ]);

            for ($j = 0; $j < fake()->numberBetween(0, 15); $j++) {
                $item = \App\Models\Product::all()->random();
                $item_price = $item->sell_price;
                $item_discount = fake()->numberBetween(0, 50);
                $item_quality = fake()->numberBetween(1, 10);
                $item_total = $item_price * $item_quality;
                $item_total = $item_total - ($item_total * $item_discount) / 100;

                InvoiceItems::create([
                    'id' => fake()->uuid(),
                    'invoice_id' => $id,
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
            }

            $invoice_items = InvoiceItems::where('invoice_id', $id)->get();

            $invoice_total = 0;
            foreach ($invoice_items as $item) {
                $invoice_total += $item->total;
            }

            Invoice::where('id', $id)->update([
                'total' => $invoice_total,
            ]);
            incrementLastItemNumber('invoice');
        }
    }
}
