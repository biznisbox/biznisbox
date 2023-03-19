<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CalendarEvents;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 250; $i++) {
            $id = fake()->uuid();

            CalendarEvents::create([
                'id' => $id,
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'start' => fake()->dateTimeBetween('-1 year', '+1 year'),
                'end' => fake()->dateTimeBetween('-1 year', '+1 year'),
                'all_day' => fake()->boolean(),
                'color' => fake()->hexColor(),
                'user_id' => \App\Models\User::all()->random()->id,
                'timezone' => fake()->timezone(),
                'show_as' => fake()->randomElement(['free', 'busy', 'tentative', 'outofoffice']),
                'privacy' => fake()->randomElement(['public', 'private', 'confidential']),
            ]);
        }
    }
}
