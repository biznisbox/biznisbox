<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:demo-reset-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset demo data used for demo purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting demo data...');

        if (config('app.demo.enabled') === true) {
            // Truncate all tables -> this works only for MySQL
            // Get all tables in the database
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map('current', $tables);
            // Truncate each table
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            // Truncate all tables except the migrations and schedule_runs table
            foreach ($tableNames as $tableName) {
                if ($tableName !== 'migrations' && $tableName !== 'schedule_runs') {
                    DB::table($tableName)->truncate();
                }
            }
            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Seed the database with demo data
            $this->call('db:seed', [
                '--class' => 'ProductionSeeder',
                '--force' => true,
            ]);

            // WorldSeeder
            $this->call('db:seed', [
                '--class' => 'WorldSeeder',
                '--force' => true,
            ]);

            // DeveloperSeeder
            $this->call('db:seed', [
                '--class' => 'DevSeeder',
                '--force' => true,
            ]);

            // Create a demo users
            $user = User::create([
                'first_name' => 'Demo',
                'last_name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ]);

            // Assign the user to the demo role
            $user->assignRole('user');
            $user->generateUserAvatar($user->id, 'Demo', 'User');

            // Create a demo admin
            $admin = User::create([
                'first_name' => 'Demo',
                'last_name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);

            // Assign the user to the demo role
            $admin->assignRole('super_admin');
            $admin->generateUserAvatar($admin->id, 'Demo', 'Admin');

            $this->info('Demo data reset successfully.');
        } else {
            $this->error('Demo mode is not enabled. Please enable it in the config/app.php file.');
        }
    }
}
