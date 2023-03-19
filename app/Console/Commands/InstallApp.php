<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        // Database connection details
        $database_type = $this->choice('Database type', ['mysql', 'pgsql', 'sqlite', 'sqlsrv'], 0);
        $database_name = $this->ask('Database name');
        $database_user = $this->ask('Database user');
        $database_password = $this->secret('Database password');
        $database_host = $this->ask('Database host');
        $database_port = $this->ask('Database port');

        // App details
        $app_name = $this->ask('App name');
        $app_url = $this->ask('App url');
        $environment = $this->choice('Environment', ['prod', 'dev'], 0);

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

            // Install composer dependencies
            $this->info(' Installing composer dependencies...');
            exec('composer install');

            // Clear route cache
            $this->info('Clearing route cache...');
            exec('php artisan route:cache');

            // Clear view cache
            $this->info('Clearing view cache...');
            exec('php artisan view:cache');

            // Migrate database
            $this->info('Migrating database...');
            exec('php artisan migrate --force');

            // Generate key
            $this->info('Generate key');
            exec('php artisan key:generate');

            // Install npm dependencies
            $this->info('Installing npm dependencies...');
            exec('npm install');

            $this->info('Cache config...');
            exec('php artisan config:cache');

            if ($environment == 'prod') {
                // Build frontend
                $this->info('Building frontend...');
                exec('npm run build');

                // Build frontend
                $this->info('Installing only production dependencies...');
                exec('npm install --omit=dev');
                // Install production composer dependencies
                $this->info('Installing production composer dependencies...');
                exec('composer install --no-dev');
            }

            // Dump autoload
            $this->info('Dumping autoload...');
            exec('composer dump-autoload --optimize');

            $this->info('App installed successfully!');
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
