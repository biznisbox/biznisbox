<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function getPayments()
    {
        $payments = $this->paymentService->getPayments();
        return api_response($payments, __('responses.data_retrieved_successfully'));
    }

    public function getPayment(Request $request, $id)
    {
        $payment = $this->paymentService->getPayment($id);
        return api_response($payment, __('responses.data_retrieved_successfully'));
    }
}
