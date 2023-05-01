<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class InstallApp extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'biznisbox:install';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Install app';

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        if (file_exists(base_path('.env'))) {
            $this->error('App already installed!');
            return Command::FAILURE;
        }

        // Database connection details
        $this->info('Database connection details - please enter your database connection details.');
        $database_type = $this->choice('Database type', ['mysql', 'pgsql', 'sqlite', 'sqlsrv'], 0);
        $database_name = $this->ask('Database name', 'biznisbox');
        $database_user = $this->ask('Database user', 'root');
        $database_password = $this->secret('Database password');
        $database_host = $this->ask('Database host', 'localhost');
        $database_port = $this->ask('Database port', '3306');

        // App details
        $this->info('App details - please enter your app details.');
        $app_name = $this->ask('App name', 'BiznisBox');
        $app_url = $this->ask('App url', 'http://localhost');
        $environment = $this->choice('Environment', ['prod', 'dev'], 0);
        $lang = $this->choice('Language', ['en', 'sl'], 0);

        // Admin user details
        $this->info('Create admin user - admin user is required to login to the app. You can create more users later.');
        $admin_name = $this->ask('Admin name', 'Admin');
        $admin_email = $this->ask('Admin email');
        $admin_password = $this->secret('Admin password');

        // Confirm
        if ($this->confirm('Do you wish to install app?')) {
            // Install app
            $this->info('Installing app...');

            // Generate JWT key
            $jwt_key = $this->generateRandomString(32);

            // Create .env file
            $this->info('Creating .env file...');
            $env = file_get_contents(base_path('.env.example'));
            $env = str_replace('APP_NAME=', 'APP_NAME="' . $app_name . '"', $env);
            $env = str_replace('APP_URL=', 'APP_URL=' . $app_url, $env);
            $env = str_replace('APP_ENV=', 'APP_ENV=' . $environment, $env);
            $env = str_replace('JWT_KEY=', 'JWT_KEY=' . $jwt_key, $env);
            $env = str_replace('DB_CONNECTION=', 'DB_CONNECTION=' . $database_type, $env);
            $env = str_replace('DB_HOST=', 'DB_HOST=' . $database_host, $env);
            $env = str_replace('DB_PORT=', 'DB_PORT=' . $database_port, $env);
            $env = str_replace('DB_DATABASE=', 'DB_DATABASE=' . $database_name, $env);
            $env = str_replace('DB_USERNAME=', 'DB_USERNAME=' . $database_user, $env);
            $env = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $database_password, $env);
            file_put_contents(base_path('.env'), $env);

            // Generate key
            $this->info('Generate key');
            exec('php artisan key:generate');

            // Migrate database
            $this->info('Migrating database...');
            exec('php artisan migrate --force');

            $this->info('Cache config...');
            exec('php artisan config:cache');

            // Clear route cache
            $this->info('Clearing route cache...');
            exec('php artisan route:cache');

            // Clear view cache
            $this->info('Clearing view cache...');
            exec('php artisan view:cache');

            $this->info('App installed successfully!');

            // Update config in runtime (for database connection)
            config(['database.connections.' . $database_type . '.host' => $database_host]);
            config(['database.connections.' . $database_type . '.port' => $database_port]);
            config(['database.connections.' . $database_type . '.database' => $database_name]);
            config(['database.connections.' . $database_type . '.username' => $database_user]);
            config(['database.connections.' . $database_type . '.password' => $database_password]);

            // Create admin user
            $this->info('Creating admin user...');
            $user = new User();
            $user->first_name = $admin_name;
            $user->email = $admin_email;
            $user->role = 'super_admin';
            $user->language = $lang;
            $user->password = bcrypt($admin_password);
            $user = $user->save();

            // Assign admin user to admin role
            $adminUser = \App\Models\User::where('role', 'super_admin')->first();
            $adminRole = Role::where('name', 'super_admin')->first();
            $adminUser->assignRole($adminRole);

            settings([
                'default_lang' => $lang,
            ]);

            if (!$user) {
                $this->error('Admin user not created!');
                return Command::FAILURE;
            }
            $this->info('Admin user created successfully!');
        }

        return Command::SUCCESS;
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
