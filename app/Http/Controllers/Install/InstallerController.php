<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Install\InstallService;

/**
 * @group Installer
 *
 * APIs for installing the application
 */
class InstallerController extends Controller
{
    private $installService;
    public function __construct(InstallService $installService)
    {
        $this->installService = $installService;
    }

    /**
     * Check requirements
     *
     * @return array $requirements Requirements
     */
    public function checkRequirements()
    {
        $requirements = $this->installService->checkRequirements();
        return apiResponse($requirements);
    }

    /**
     * Check database connection
     *
     * @param  object  $request data from the form (db_host, db_port, db_name, db_username, db_password)
     * @return array $check Check
     */
    public function checkDbConnection(Request $request)
    {
        $data = $request->all();
        $check = $this->installService->checkDbConnection($data);
        return apiResponse($check);
    }

    /**
     * Update .env file with database information
     *
     * @param  object  $request data from the form (db_host, db_port, db_name, db_username, db_password)
     * @return array $updated Updated
     */
    public function updateEnvFileWithDbInfo(Request $request)
    {
        $data = $request->all();
        $updated = $this->installService->updateEnvFileWithDbInfo($data);
        return apiResponse($updated);
    }

    /**
     * Migrate and seed database
     *
     * @return array $migration Migration
     */
    public function migrateAndSeed()
    {
        $migration = $this->installService->migrateAndSeed();
        return apiResponse($migration);
    }

    /**
     * Set settings in database
     *
     * @param  object  $request data from the form (app_name, app_url, app_timezone, app_locale, app_currency, app_currency_symbol, app_currency_position)
     * @return array $settings Settings
     */
    public function setSettingsInDb(Request $request)
    {
        $data = $request->all();
        $settings = $this->installService->setSettingsInDb($data);
        return apiResponse($settings);
    }

    /**
     * Create admin user
     *
     * @param  object  $request data from the form (name, email, password)
     * @return array $user User
     */
    public function createAdminUser(Request $request)
    {
        $data = $request->all();
        $user = $this->installService->createAdminUser($data);
        return apiResponse($user);
    }

    /**
     * Check if app is installed
     *
     * @return array $installed Installed
     */
    public function checkAppInstalled()
    {
        $installed = $this->installService->checkIfAppInstalled();
        return apiResponse($installed);
    }

    /**
     * Get database information from .env file
     *
     * @return array $dbInfo Database information
     */
    public function getDbInfoFromEnv()
    {
        $dbInfo = $this->installService->getDbSettingsFromEnv();
        return apiResponse($dbInfo);
    }
}
