<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenBankingService;
use Illuminate\Support\Facades\Log;

class OpenBankingController extends Controller
{
    protected $openBankingService;

    public function __construct(OpenBankingService $openBankingService)
    {
        $this->openBankingService = $openBankingService;
    }

    public function getBanks(Request $request)
    {
        $country = $request->country;
        return $this->openBankingService->getBanks($country);
    }

    public function getBankById(Request $request)
    {
        $id = $request->id;
        return $this->openBankingService->getBankById($id);
    }

    public function initSession(Request $request)
    {
        $redirectUri = url('/accounts');
        $institutionId = $request->institution_id;
        return $this->openBankingService->initSession($redirectUri, $institutionId);
    }

    public function getRequisition(Request $request)
    {
        $requisitionId = $request->requisition_id;
        return $this->openBankingService->getRequisition($requisitionId);
    }
}
