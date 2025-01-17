<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

/**
 * @group Payments
 *
 * APIs for managing payments
 */
class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Get all payments
     *
     * @return array $payments Payments
     */
    public function getPayments()
    {
        $payments = $this->paymentService->getPayments();
        return api_response($payments, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get payment by id
     *
     * @param  string  $id id of the payment
     * @return array $payment payment
     */
    public function getPayment(Request $request, $id)
    {
        $payment = $this->paymentService->getPayment($id);
        return api_response($payment, __('responses.data_retrieved_successfully'));
    }
}
