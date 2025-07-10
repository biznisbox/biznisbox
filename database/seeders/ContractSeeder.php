<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 40; $i++) {
            $id = fake()->uuid();
            $content = fake()->paragraphs(15, true);
            \App\Models\Contract::create([
                'id' => $id,
                'title' => fake()->sentence(3),
                'user_id' => \App\Models\User::all()->random()->id,
                'number' => Contract::getContractNumber(),
                'description' => fake()->text(200),
                'status' => fake()->randomElement(['draft', 'waiting_signers', 'rejected', 'signed']),
                'type' => fake()->randomElement(['contract', 'agreement', 'NDA', 'SLA']),
                'content' => $content,
                'start_date' => fake()->dateTime(),
                'end_date' => fake()->dateTime(),
                'version' => fake()->numberBetween(1, 10),
                'date_for_signature' => fake()->dateTime(),
                'sha256' => hash('sha256', $content),
            ]);

            for ($j = 0; $j < 3; $j++) {
                \App\Models\ContractSigner::create([
                    'contract_id' => $id,
                    'signer_name' => fake()->name(),
                    'signer_email' => fake()->email(),
                    'signer_phone' => fake()->phoneNumber(),
                    'signer_notes' => fake()->text(100),
                    'status' => fake()->randomElement(['signed', 'unsigned', 'rejected', 'waiting_signature']),
                    'sign_order' => $j + 1,
                ]);
            }
            incrementLastItemNumber('contract', settings('contract_number_format'));
        }
    }
}
