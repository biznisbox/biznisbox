<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getDashboardData(Request $request)
    {
        $partner = $this->dashboardService->getPartnerDashboardData();

        if (!$partner) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($partner, __('responses.data_retrieved_successfully'));
    }
}
