<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Parsedown;

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
}
