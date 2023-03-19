<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OnlinePaymentService;

class OnlinePaymentController extends Controller
{
    public $onlinePaymentService;
    public function __construct(OnlinePaymentService $onlinePaymentService)
    {
        $this->onlinePaymentService = $onlinePaymentService;
    }

    public function makeStripePayment(Request $request)
    {
        return $this->onlinePaymentService->makeStripePayment($request);
    }

    public function validateStripePayment(Request $request, $status)
    {
        return $this->onlinePaymentService->validateStripePayment($request, $status);
    }

    public function makePaypalPayment(Request $request)
    {
        return $this->onlinePaymentService->makePaypalPayment($request);
    }

    public function validatePaypalPayment(Request $request, $status)
    {
        return $this->onlinePaymentService->validatePaypalPayment($request, $status);
    }
}
