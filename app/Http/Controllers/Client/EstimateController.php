<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estimate;
use App\Services\Client\EstimateService;

class EstimateController extends Controller
{
    protected $estimateService;

    public function __construct(EstimateService $estimateService)
    {
        $this->estimateService = $estimateService;
    }

    public function getEstimate(Request $request)
    {
        $key = $request->key;
        return $this->estimateService->getEstimate($key);
    }

    public function acceptRejectEstimate(Request $request)
    {
        $key = $request->key;
        $data = $request->status;
        return $this->estimateService->acceptRejectEstimate($key, $data);
    }
}
