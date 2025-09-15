<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

/**
 * @group Payments
 *
 * APIs for managing payments
 * @authenticated
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
        return apiResponse($payments, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get payment by id
     *
     * @param  string  $id id of the payment
     * @return array $payment payment
     */
    public function getPayment($id)
    {
        $payment = $this->paymentService->getPayment($id);
        if (!$payment) {
            return apiResponse(null, __('responses.data_not_found'), 404);
        }
        return apiResponse($payment, __('responses.data_retrieved_successfully'));
    }

    /**
     * Make a refund for a payment
     *
     * @param  string  $id id of the payment
     * @return array $result result of the refund operation
     */
    public function makePaymentRefund($id)
    {
        $result = $this->paymentService->makePaymentRefund($id);
        if (!$result) {
            return apiResponse(null, __('responses.refund_failed'), 400);
        }

        return apiResponse($result, __('responses.data_retrieved_successfully'));
    }
}
