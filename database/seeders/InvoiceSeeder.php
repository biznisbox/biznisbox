<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $id = fake()->uuid();

            $customer = \App\Models\Partner::all()->random();
            $customer_address = $customer->addresses->first();
            $payment_method = \App\Models\Category::where('module', 'payment_method')->get()->random();
            $discount = fake()->randomFloat(2, 0, 100);
            \App\Models\Invoice::create([
                'id' => $id,
                'number' => \App\Models\Invoice::getInvoiceNumber(),
                'sales_person_id' => \App\Models\Employee::all()->random()->id,
                'type' => 'invoice',
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_address' => $customer_address->address,
                'customer_city' => $customer_address->city,
                'customer_zip_code' => $customer_address->zip_code,
                'customer_country' => $customer_address->country,
                'customer_address_id' => $customer_address->id,
                'payer_id' => $customer->id,
                'payer_name' => $customer->name,
                'payer_address' => $customer_address->address,
                'payer_city' => $customer_address->city,
                'payer_zip_code' => $customer_address->zip_code,
                'payer_country' => $customer_address->country,
                'payer_address_id' => $customer_address->id,
                'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'due_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'status' => fake()->randomElement(['draft', 'sent', 'paid', 'cancelled', 'partial', 'overdue', 'refunded', 'unpaid']),
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
                \App\Models\InvoiceItem::create([
                    'id' => fake()->uuid(),
                    'product_id' => $product->id,
                    'invoice_id' => $id,
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

            $invoice = \App\Models\Invoice::find($id);
            $invoice->total = $total - ($total * $discount) / 100;
            $invoice->save();

            incrementLastItemNumber('invoice', settings('invoice_number_format'));
        }
    }
}
