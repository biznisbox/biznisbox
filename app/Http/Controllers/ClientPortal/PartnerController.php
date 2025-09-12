<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\PartnerService;

/**
 * @group Client Portal Partners
 *
 * APIs for managing partner details in the client portal
 */
class PartnerController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    /**
     * Get partner details from current logged in user in the client portal
     *
     * @return Partner $partner Partner details
     * @authenticated
     */
    public function getPartnerDetails(Request $request)
    {
        $partner = $this->partnerService->getPartner();

        if (!$partner) {
            return apiResponse(null, __('responses.item_not_found'), 404);
        }

        return apiResponse($partner, __('responses.data_retrieved_successfully'));
    }
}
