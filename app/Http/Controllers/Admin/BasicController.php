<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\DashboardService;

class BasicController extends Controller
{
    public function getDashboardData(DashboardService $dashboardService)
    {
        $data = $dashboardService->getDashboardData();

        return api_response($data);
    }
}
