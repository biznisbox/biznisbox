<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\DashboardDataService;

/**
 * @group Dashboard Data
 *
 * APIs for managing dashboard data
 * @authenticated
 */
class DashboardDataController extends Controller
{
    private $dashboardDataService;
    public function __construct(DashboardDataService $dashboardDataService)
    {
        $this->dashboardDataService = $dashboardDataService;
    }

    /**
     * Return data for the dashboard
     *
     * @param  object  $request data from the form (type)
     * @return array $data data
     */
    public function returnData(Request $request)
    {
        $type = $request->input('type');
        $data = $this->dashboardDataService->returnData($type);
        return apiResponse($data, __('responses.data_retrieved_successfully'), 200);
    }
}
