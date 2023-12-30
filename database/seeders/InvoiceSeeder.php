<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItems;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $id = fake()->uuid();
            $customer_id = \App\Models\Partner::where('type', 'customer')
                ->orWhere('type', 'both')
                ->get()
                ->random()->id;
            $customer_data = \App\Models\Partner::find($customer_id);
            $customer_address_id = \App\Models\PartnerAddress::where('partner_id', $customer_id)
                ->get()
                ->random()->id;
            $customer_address_data = \App\Models\PartnerAddress::find($customer_address_id);
            Invoice::create([
                'id' => $id,
                'number' => Invoice::getInvoiceNumber(),
                'sales_person_id' => \App\Models\Employee::all()->random()->id,
                'status' => fake()->randomElement(['draft', 'sent', 'paid', 'cancelled']),
                'date' => fake()->dateTimeBetween('-1 years', 'now'),
                'due_date' => fake()->dateTimeBetween('-1 years', 'now'),
                'notes' => fake()->text(200),
                'footer' => fake()->text(200),
                'currency' => fake()->randomElement(['EUR', 'USD', 'GBP']),
                'discount' => fake()->randomFloat(2, 0, 100),
                'total' => 0,
                'customer_id' => $customer_id,
                'customer_name' => $customer_data->name,
                'customer_address_id' => $customer_address_id,
                'customer_address' => $customer_address_data->address,
                'customer_city' => $customer_address_data->city,
                'customer_zip_code' => $customer_address_data->zip,
                'customer_country' => $customer_address_data->country,
                'payer_id' => $customer_id,
                'payer_name' => $customer_data->name,
                'payer_address_id' => $customer_address_id,
                'payer_address' => $customer_address_data->address,
                'payer_city' => $customer_address_data->city,
                'payer_zip_code' => $customer_address_data->zip,
                'payer_country' => $customer_address_data->country,
                'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'check', 'stripe', 'paypal']),
            ]);

            for ($j = 0; $j < 3; $j++) {
                $product = \App\Models\Product::all()->random();
                $quality = fake()->numberBetween(1, 10);
                $discount = fake()->randomFloat(2, 0, 100);
                InvoiceItems::create([
                    'id' => fake()->uuid(),
                    'invoice_id' => $id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'description' => fake()->sentence(),
                    'price' => $product->sell_price,
                    'quantity' => $quality,
                    'unit' => $product->unit,
                    'discount' => $discount,
                    'tax' => $product->tax,
                    'total' => $product->sell_price * $quality - $product->sell_price * $quality * ($discount / 100),
                ]);
            }

            // Calculate totals
            $invoice = Invoice::find($id);

            $items = InvoiceItems::where('invoice_id', $id)->get();
            $total = 0;
            foreach ($items as $item) {
                $total += $item->total;
            }
            $discount = $invoice->discount;
            $invoice->total = $total - $total * ($discount / 100);
            $invoice->save();

            incrementLastItemNumber('invoice');
        }
    }
}
