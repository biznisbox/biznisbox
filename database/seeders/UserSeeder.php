<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'id' => fake()->uuid(),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()
                    ->unique()
                    ->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
            $user->assignRole(fake()->randomElement(['super_admin', 'user']));
        }
    }
}
