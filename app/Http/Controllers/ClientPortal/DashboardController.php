<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\DashboardService;
/**
 * @group Client Portal Dashboard
 *
 * APIs for get dashboard data in the client portal
 */

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Get dashboard data
     *
     * @return array $partner Dashboard data
     * @authenticated
     */
    public function getDashboardData()
    {
        $partner = $this->dashboardService->getClientPortalDashboardData();

        if (!$partner) {
            return apiResponse(null, __('responses.item_not_found'), 404);
        }

        return apiResponse($partner, __('responses.data_retrieved_successfully'));
    }
}
