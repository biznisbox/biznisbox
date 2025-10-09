<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $projectId = fake()->uuid();

            $project = \App\Models\Project::create([
                'id' => $projectId,
                'number' => Project::getProjectNumber(),
                'created_by' => \App\Models\User::all()->random()->value('id'),
                'name' => fake()->company(),
                'description' => fake()->text(200),
                'start_date' => fake()->dateTimeInInterval('-1 year', '+1 month'),
                'end_date' => fake()->dateTimeInInterval('-1 year', '+1 month'),
                'status' => fake()->randomElement(['planned', 'in_progress', 'completed', 'on_hold']),
                'budget' => fake()->randomFloat(2, 1000, 100000),
                'active' => fake()->boolean(),
                'is_billable' => fake()->boolean(),
                'priority' => fake()->randomElement(['low', 'medium', 'high']),
                'partner_id' => \App\Models\Partner::all()->random()->value('id'),
                'project_key' => 'PROJ' . strtoupper(fake()->bothify('??###')),
            ]);

            incrementLastItemNumber('projects', settings('project_number_format'));

            $usersList = [];

            for ($j = 0; $j < fake()->numberBetween(5, 20); $j++) {
                $userId = \App\Models\User::all()->random()->value('id');

                if (in_array($userId, $usersList)) {
                    continue; // Skip if user is already a member
                }

                $usersList = array_merge($usersList, [$userId]);
                DB::table('project_members')->insert([
                    'id' => fake()->uuid(),
                    'project_id' => $projectId,
                    'user_id' => $userId,
                    'project_role' => fake()->randomElement(['manager', 'owner', 'viewer', 'team_member', 'client']),
                ]);
            }

            for ($k = 0; $k < fake()->numberBetween(30, 50); $k++) {
                $taskId = fake()->uuid();
                \App\Models\Task::create([
                    'id' => $taskId,
                    'project_id' => $projectId,
                    'title' => fake()->sentence(3),
                    'description' => fake()->text(1000),
                    'status' => fake()->randomElement(['to_do', 'in_progress', 'done']),
                    'priority' => fake()->randomElement(['low', 'medium', 'high']),
                    'start_date' => fake()->dateTimeInInterval('-1 year', '+6 months'),
                    'due_date' => fake()->dateTimeInInterval('-1 year', '+6 months'),
                    'progress_in_percent' => fake()->numberBetween(0, 100),
                    'assigned_to' => $usersList[array_rand($usersList)],
                    'type' => fake()->randomElement(['task', 'milestone']),
                    'number' => \App\Models\Task::generateTaskNumber($projectId),
                    'created_by' => \App\Models\User::all()->random()->value('id'),
                    'active' => fake()->boolean(),
                ]);
                incrementProjectTaskNumber($project->project_key);
            }
        }
    }
}
