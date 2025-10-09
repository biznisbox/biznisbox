<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Parsedown;
use Illuminate\Support\Facades\Log;

class StatusService
{
    public function getVersion()
    {
        // Read the version from the composer.json file
        $composer = json_decode(File::get(base_path('composer.json')), true);

        // Get the latest version from the GitHub repository
        $repoRelease = Http::get('https://api.github.com/repos/biznisbox/biznisbox/releases/latest')->json();
        $latestVersion = $repoRelease['tag_name'];
        $latestVersion = str_replace('v', '', $latestVersion); // remove the 'v' prefix

        $downloadUrl = $repoRelease['assets'][0]['browser_download_url'];

        // Get the release notes from the GitHub repository and convert them to HTML
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        $changelog = $parsedown->text($repoRelease['body']);

        createActivityLog('retrieve', null, 'App\Services\Admin\StatusService', 'getVersion');

        return [
            'current_version' => $composer['version'],
            'latest_version' => $latestVersion,
            'download_url' => $downloadUrl,
            'changelog' => $changelog,
            'is_up_to_date' => version_compare($composer['version'], $latestVersion) >= 0,
        ];
    }

    public function getServerStatus()
    {
        $server = [
            'php_version' => phpversion(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'database_version' => $this->getDatabaseVersion(),
            'storage_limit' => config('filesystems.storage_limit'),
            'storage_used' => calculateStorageUsage(),
            'storage_free' =>
                config('filesystems.storage_limit') == -1 ? -1 : config('filesystems.storage_limit') - calculateStorageUsage(),
            'storage_usage_percentage' =>
                config('filesystems.storage_limit') == -1
                    ? -1
                    : round((calculateStorageUsage() / config('filesystems.storage_limit')) * 100, 2), // percentage
        ];

        createActivityLog('retrieve', null, 'App\Services\Admin\StatusService', 'getServerStatus');

        return $server;
    }

    private function getDatabaseVersion()
    {
        $connection = config('database.default');
        $version = 'N/A';

        switch ($connection) {
            case 'mysql':
                $version = DB::selectOne('SELECT VERSION() as version')->version;
                break;
            case 'pgsql':
                $version = DB::selectOne('SHOW server_version')->server_version;
                break;
            case 'sqlite':
                $version = DB::selectOne('SELECT sqlite_version() as version')->version;
                break;
            case 'sqlsrv':
                $version = DB::selectOne('SELECT @@VERSION as version')->version;
                break;
            default:
                $version = 'Unknown database type';
                break;
        }

        return $version;
    }
}
