<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\DashboardDataService;

class DashboardDataController extends Controller
{
    private $dashboardDataService;
    public function __construct(DashboardDataService $dashboardDataService)
    {
        $this->dashboardDataService = $dashboardDataService;
    }

    public function returnData(Request $request)
    {
        $type = $request->input('type');
        $data = $this->dashboardDataService->returnData($type);
        return api_response($data, __('responses.data_retrieved_successfully'), 200);
    }
}
