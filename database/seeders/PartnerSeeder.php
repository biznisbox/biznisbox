<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\PartnerAddress;
use App\Models\PartnerContact;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $id = fake()->uuid();
            Partner::create([
                'id' => $id,
                'assignee_id' => \App\Models\User::all()->random()->id,
                'number' => \App\Models\Partner::getPartnerNumber(),
                'name' => fake()->company(),
                'type' => fake()->randomElement(['customer', 'supplier', 'both', 'other']),
                'entity_type' => fake()->randomElement(['individual', 'company']),
                'vat_number' => fake()->randomNumber(8),
                'language' => fake()->randomElement(['en', 'sl', 'de']),
                'notes' => fake()->text(200),
                'website' => fake()->url(),
                'size' => fake()->randomElement(['small', 'medium', 'large']),
                'currency' => fake()->randomElement(['EUR', 'USD', 'GBP']),
                'industry' => fake()->randomElement([
                    'automotive',
                    'banking',
                    'legal',
                    'food',
                    'media',
                    'nonprofit',
                    'shipping',
                    'other',
                    'banking',
                    'technology',
                    'telecommunications',
                    'transportation',
                    'IT',
                ]),
                'status' => fake()->randomElement(['active', 'inactive']),
            ]);
            for ($j = 0; $j < 3; $j++) {
                PartnerAddress::create([
                    'id' => fake()->uuid(),
                    'partner_id' => $id,
                    'type' => fake()->randomElement(['billing', 'shipping']),
                    'address' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'zip_code' => fake()->postcode(),
                    'country' => fake()->country(),
                ]);
            }

            for ($j = 0; $j < 3; $j++) {
                PartnerContact::create([
                    'id' => fake()->uuid(),
                    'partner_id' => $id,
                    'is_primary' => fake()->boolean(),
                    'name' => fake()->name(),
                    'function' => fake()->jobTitle(),
                    'email' => fake()->email(),
                    'phone_number' => fake()->phoneNumber(),
                    'mobile_number' => fake()->phoneNumber(),
                    'fax_number' => fake()->phoneNumber(),
                    'notes' => fake()->text(200),
                ]);
            }
            incrementLastItemNumber('partner', settings('partner_number_format'));
        }
    }
}
