<?php

namespace App\Services\Install;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class InstallService
{
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

    public function migrateDb()
    {
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

    public function checkEnvFile()
    {
        $envFile = base_path('.env');
        if (file_exists($envFile)) {
            return true;
        }
        return false;
    }

    public function createEnvFile()
    {
        $envFile = base_path('.env.example');
        $newEnvFile = base_path('.env');
        if (file_exists($envFile)) {
            copy($envFile, $newEnvFile);
        }
    }

    public function migrateAndSeed()
    {
        $migration = $this->migrateDb();
        $seeder = $this->seedDb();

        if ($migration && $seeder) {
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

    public function setAppInstalled()
    {
        writeInEnvFile([
            'APP_INSTALLED' => 'true',
        ]);

        // Create install.lock file
        if (!file_exists(base_path('install.lock'))) {
            $file = fopen(base_path('install.lock'), 'w');
            fclose($file);
        }

        settings(['app_installed' => true], 'set');
    }

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

    public function isAppInstalled()
    {
        if (env('APP_INSTALLED') == 'true' || file_exists(base_path('install.lock'))) {
            return true;
        }
    }

    public function setSettingsInDb($data)
    {
        settings($data, 'set');

        return [
            'status' => true,
            'message' => __('responses.data_saved_successfully'),
        ];
    }

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

    public function checkAppInstalled()
    {
        if ($this->isAppInstalled()) {
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
