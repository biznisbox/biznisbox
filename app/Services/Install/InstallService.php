<?php

namespace App\Services\Install;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class InstallService
{
    /**
     * Create a database connection
     *
     * @param  array  $data Database connection data
     * @return \Illuminate\Database\Connection
     */
    public function createConnection($data)
    {
        $driver = $data['driver'];
        $host = $data['host'];
        $port = $data['port'];
        $database = $data['database'];
        $username = $data['username'];
        $password = $data['password'];

        config([
            'database.connections.' . $driver => [
                'driver' => $driver,
                'host' => $host,
                'port' => $port,
                'database' => $database,
                'username' => $username,
                'password' => $password,
            ],
        ]);

        return DB::connection($driver);
    }

    /**
     * Check database connection
     *
     * @param  array  $data Database connection data
     * @return array $check Check
     */
    public function checkDbConnection($data)
    {
        try {
            $check = false;
            $pdo = $this->createConnection($data)->getPdo();

            $version = $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);

            // Check if the database is empty
            $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

            if (count($tables) > 0) {
                $check = [
                    'status' => false,
                    'message' => __('responses.install_database_is_not_empty'),
                    'error' => __('responses.install_database_is_not_empty'),
                ];
            } else {
                $check = [
                    'status' => true,
                    'message' => __('responses.install_database_connection_successful'),
                    'version' => $version,
                ];
            }
        } catch (\Exception $e) {
            $check = [
                'status' => false,
                'message' => __('responses.install_database_connection_failed'),
                'error' => $e->getMessage(),
            ];
        }
        return $check;
    }

    /**
     * Get database settings from .env file
     *
     * @return array $dbSettings Database settings
     */
    public function getDbSettingsFromEnv()
    {
        $dbSettings = [
            'driver' => env('DB_CONNECTION'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ];

        return $dbSettings;
    }

    /**
     * Update .env file with database information
     *
     * @param  array  $data Database connection data
     * @return array $updated Updated
     */
    public function updateEnvFileWithDbInfo($data)
    {
        $data = [
            'DB_CONNECTION' => $data['driver'],
            'DB_HOST' => $data['host'],
            'DB_PORT' => $data['port'],
            'DB_DATABASE' => $data['database'],
            'DB_USERNAME' => $data['username'],
            'DB_PASSWORD' => $data['password'],
        ];

        writeInEnvFile($data);

        return [
            'status' => true,
            'message' => __('responses.install_database_connection_saved'),
        ];
    }

    /**
     * Migrate database tables
     *
     * @return array $migration Migration
     */
    public function migrateDb()
    {
        // Migrate the database
        try {
            $migration = Artisan::call('migrate', [
                '--force' => true,
            ]);

            if ($migration === 0) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Seed the database
     *
     * @return array $seeder Seeder
     */
    public function seedDb()
    {
        // Seed the database
        try {
            $seeder = Artisan::call('db:seed', [
                '--class' => 'ProductionSeeder',
                '--force' => true,
            ]);

            if ($seeder == 0) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Check requirements
     *
     * @return array $requirements Requirements
     */
    public function checkRequirements()
    {
        $requirements = [];
        // Check PHP version
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '8.2.0', '<')) {
            $requirements['php_version'] = false;
        } else {
            $requirements['php_version'] = true;
        }

        // Check PHP extensions
        $requiredExtensions = [
            'bcmath',
            'ctype',
            'curl',
            'dom',
            'fileinfo',
            'gd',
            'json',
            'mbstring',
            'openssl',
            'pdo',
            'tokenizer',
            'xml',
            'zip',
        ];

        foreach ($requiredExtensions as $extension) {
            if (!extension_loaded($extension)) {
                $requirements['php_extensions'][$extension] = false;
            } else {
                $requirements['php_extensions'][$extension] = true;
            }
        }

        // Check file permissions
        if (!is_writable(base_path('storage'))) {
            $requirements['storage_permissions'] = false;
        } else {
            $requirements['storage_permissions'] = true;
        }

        if (!is_writable(base_path('bootstrap/cache'))) {
            $requirements['bootstrap_cache_permissions'] = false;
        } else {
            $requirements['bootstrap_cache_permissions'] = true;
        }

        if (!$this->checkEnvFile()) {
            $this->createEnvFile();
        }

        if (!is_writable(base_path('.env'))) {
            $requirements['env_permissions'] = false;
        } else {
            $requirements['env_permissions'] = true;
        }

        return $requirements;
    }

    /**
     * Check if .env file exists
     *
     * @return bool
     */
    public function checkEnvFile()
    {
        $envFile = base_path('.env');
        if (file_exists($envFile)) {
            return true;
        }
        return false;
    }

    /**
     * Create .env file from .env.example
     *
     * @return void
     */
    public function createEnvFile()
    {
        $envFile = base_path('.env.example');
        $newEnvFile = base_path('.env');
        if (file_exists($envFile)) {
            copy($envFile, $newEnvFile);
        }
    }

    /**
     * Migrate and seed database
     *
     * @return array $migration Migration
     */
    public function migrateAndSeed()
    {
        Artisan::call('cache:clear');
        $migration = $this->migrateDb();
        $seeder = $this->seedDb();

        if ($migration && $seeder) {
            Artisan::call('db:seed', [
                '--class' => 'WorldSeeder',
                '--force' => true,
            ]); // Seed the world data -> if failed, it must be seeded manually
            // Set cache driver to database -> after seeding the database to avoid cache issues
            writeInEnvFile([
                'CACHE_STORE' => 'database',
            ]);
            return [
                'status' => true,
                'message' => __('responses.install_migration_and_seeding_successful'),
            ];
        }
        return [
            'status' => false,
            'message' => __('responses.install_migration_and_seeding_failed'),
        ];
    }

    /**
     * Set app installed
     *
     * @return void
     */
    public function setAppInstalled()
    {
        // Create install.lock file
        if (!file_exists(storage_path('install.lock'))) {
            $file = fopen(storage_path('install.lock'), 'w');
            if ($file) {
                fwrite($file, 'installed');
            } else {
                Log::error('Failed to create install.lock file');
            }
            fclose($file);
        }

        settings(['app_installed' => true], 'set');
    }

    /**
     * Set JWT secret
     *
     * @return array $jwtSecret JWT secret
     */
    public function setJwtSecret()
    {
        writeInEnvFile([
            'JWT_SECRET' => Str::random(64),
        ]);

        return [
            'status' => true,
            'message' => __('responses.install_jwt_secret_generated'),
        ];
    }

    /**
     * Set settings in database
     *
     * @param  array  $data Settings data
     * @return array $settings Settings
     */
    public function setSettingsInDb($data)
    {
        settings($data, 'set');

        return [
            'status' => true,
            'message' => __('responses.data_saved_successfully'),
        ];
    }

    /**
     * Create admin user
     *
     * @param  array  $data User data
     * @return array $user User
     */
    public function createAdminUser($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'super_admin',
        ]);
        $user->assignRole('super_admin');
        $user->generateUserAvatar($user->id, $data['first_name'], $data['last_name']);

        $this->setAppInstalled();
        $this->setJwtSecret();

        Artisan::call('storage:link');
        Artisan::call('cache:clear');

        return [
            'status' => true,
            'message' => __('responses.install_admin_user_created'),
        ];
    }

    /**
     * Check if app is installed
     *
     * @return array $installed Installed
     */
    public function checkIfAppInstalled()
    {
        if (isAppInstalled()) {
            return [
                'status' => true,
                'message' => __('responses.app_installed'),
            ];
        }
        return [
            'status' => false,
            'message' => __('responses.app_not_installed'),
        ];
    }
}
