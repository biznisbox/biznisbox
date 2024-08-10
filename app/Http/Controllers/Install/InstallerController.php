<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Install\InstallService;

class InstallerController extends Controller
{
    private $installService;

    public function __construct(InstallService $installService)
    {
        $this->installService = $installService;
    }

    public function checkRequirements()
    {
        $requirements = $this->installService->checkRequirements();
        return api_response($requirements);
    }

    public function checkDbConnection(Request $request)
    {
        $data = $request->all();
        $check = $this->installService->checkDbConnection($data);
        return api_response($check);
    }

    public function updateEnvFileWithDbInfo(Request $request)
    {
        $data = $request->all();
        $updated = $this->installService->updateEnvFileWithDbInfo($data);
        return api_response($updated);
    }

    public function migrateAndSeed()
    {
        $migration = $this->installService->migrateAndSeed();
        return api_response($migration);
    }

    public function setSettingsInDb(Request $request)
    {
        $data = $request->all();
        $settings = $this->installService->setSettingsInDb($data);
        return api_response($settings);
    }

    public function createAdminUser(Request $request)
    {
        $data = $request->all();
        $user = $this->installService->createAdminUser($data);
        return api_response($user);
    }

    public function checkAppInstalled()
    {
        $installed = $this->installService->checkAppInstalled();
        return api_response($installed);
    }
}
