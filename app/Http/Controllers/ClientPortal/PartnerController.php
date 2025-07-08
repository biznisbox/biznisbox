<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\PartnerService;

class PartnerController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function getPartnerDetails(Request $request)
    {
        $partner = $this->partnerService->getPartner();

        if (!$partner) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($partner, __('responses.data_retrieved_successfully'));
    }
}
