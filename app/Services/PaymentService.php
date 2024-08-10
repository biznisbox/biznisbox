<?php

namespace App\Services;

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
        $onlinePayments = $this->onlinePayment->all();
        return $onlinePayments;
    }

    public function getPayment($id)
    {
        $payment = $this->onlinePayment->find($id);
        return $payment;
    }
}
