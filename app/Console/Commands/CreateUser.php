<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biznisbox:create-user {email} {password} {first_name} {last_name} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $user = User::create([
                'email' => $this->argument('email'),
                'password' => Hash::make($this->argument('password')),
                'first_name' => $this->argument('first_name'),
                'last_name' => $this->argument('last_name'),
            ]);

            if ($user) {
                $role = Role::where('name', $this->argument('role'))->first();
                if (!$role) {
                    $this->error('Entered role does not exist.');
                    return Command::FAILURE;
                }
                $user->assignRole($role);
                $user->generateUserAvatar($user->id, $this->argument('first_name'), $this->argument('last_name'));
                $this->info('User created successfully.');
                return Command::SUCCESS;
            }
            $this->error('User could not be created.');
            return Command::FAILURE;
        } catch (\Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}
