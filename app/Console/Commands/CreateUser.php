<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biznisbox:create-user {email} {password} {name} {--surname=} {--role=} {--lang=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user for BiznisBox';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $user = User::create([
                'email' => $this->argument('email'),
                'password' => Hash::make($this->argument('password')),
                'first_name' => $this->argument('name'),
                'last_name' => $this->option('surname') ?? null,
                'role' => $this->option('role') ?? 'user',
                'lang' => $this->option('lang') ?? 'en',
            ]);

            if ($user) {
                $role = Role::where('name', $user->role)->first(); // Fetch the newly created user role
                if (!$role) {
                    $this->error('Role not found.'); // Display this message in console
                    return Command::FAILURE;
                }
                $user->assignRole($role); // Assign role to user
                $this->info('User created successfully.'); // Display this message in console
                return Command::SUCCESS;
            }
            $this->error('User not created.'); // Display this message in console
            return Command::FAILURE;
        } catch (\Exception $e) {
            $this->error($e->getMessage()); // Display this message in console
            return Command::FAILURE;
        }
    }
}
