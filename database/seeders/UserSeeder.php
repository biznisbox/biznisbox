<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $role = \App\Models\Role::all()->random();
            $user = \App\Models\User::create([
                'id' => fake()->uuid(),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'active' => fake()->boolean(),
                'language' => fake()->randomElement(['en', 'de', 'sl']),
                'timezone' => fake()->timezone(),
                'theme' => fake()->randomElement(['light', 'dark']),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
            $user->assignRole($role->id);
            $user->generateUserAvatar($user->id, $user->first_name, $user->last_name);
        }
    }
}
