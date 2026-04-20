<?php

namespace App\Services;

use App\Integrations\Stripe;
use App\Models\OnlinePayment;

class PaymentService
{
    private $onlinePayment;
    public function __construct(OnlinePayment $onlinePayment)
    {
        $this->onlinePayment = $onlinePayment;
    }

    public function getPayments()
    {
        $payments = $this->onlinePayment->all();
        createActivityLog('retrieve', null, OnlinePayment::$modelName, 'OnlinePayment');
        return $payments;
    }

    public function getPayment($id)
    {
        $payment = $this->onlinePayment->find($id);

        if (!$payment) {
            return null;
        }

        switch ($payment->payment_method) {
            case 'stripe':
                $paymentDetails = Stripe::retrievePaymentIntent($payment->payment_ref);
                break;
            default:
                $paymentDetails = null;
                break;
        }

        $payment->details = $paymentDetails;
        createActivityLog('retrieve', $payment->id, OnlinePayment::$modelName, 'OnlinePayment');

        return $payment;
    }

    public function makePaymentRefund($id)
    {
        $payment = $this->onlinePayment->find($id);

        if (!$payment) {
            return ['error' => __('responses.payment_not_found')];
        }

        if ($payment->status !== 'paid') {
            return ['error' => __('responses.payment_not_refundable')];
        }

        $result = null;

        if ($payment->payment_method === 'stripe') {
            try {
                $result = Stripe::refundPayment($payment->payment_ref);
            } catch (\Exception $e) {
                return ['error' => $e->getMessage()];
            }
        } else {
            return ['error' => __('responses.payment_method_not_supported')];
        }

        if (isset($result['error'])) {
            return $result;
        }

        $payment->status = 'refunded';
        $payment->save();

        createActivityLog('paymentRefunded', $payment->id, OnlinePayment::$modelName, 'OnlinePayment');
        return $payment;
    }
}
