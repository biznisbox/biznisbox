<?php

namespace App\Integrations;

use Omnipay\Omnipay;

class PayPal
{
    private $config;
    private $gateway;
    public function __construct()
    {
        $this->config = settings(['paypal_available', 'paypal_client_id', 'paypal_secret', 'paypal_test_mode']);

        $this->gateway = Omnipay::create('PayPal_Rest');

        $this->gateway->initialize([
            'clientId' => $this->config['paypal_client_id'],
            'secret' => $this->config['paypal_secret'],
            'testMode' => $this->config['paypal_test_mode'],
        ]);
    }

    /**
     * @param Invoice $invoice Invoice to be paid
     * @param array $metadata Metadata to be attached to the session
     * @param string $success_url URL to redirect to if payment is successful
     * @param string $cancel_url URL to redirect to if payment is cancelled
     * @return object $session Checkout stripe session object
     **/
    public function createCheckoutForInvoicePayment($invoice, $metadata, $success_url, $cancel_url)
    {
        $payment = $this->gateway
            ->purchase([
                'amount' => $invoice->total,
                'currency' => $invoice->currency,
                'description' => __('Payment for Invoice #:invoice', [
                    'invoice' => $invoice->number,
                ]),
                'returnUrl' => $success_url,
                'cancelUrl' => $cancel_url,
                'metadata' => $metadata,
            ])
            ->send();

        if ($payment->isRedirect()) {
            $payment = $payment->getData();
            return $payment;
        }
        return $payment->getMessage();
    }

    /**
     * @param string $payment_id Payment ID to be validated
     * @return object $payment Payment object
     **/
    public function validateInvoicePayPalPayment($payment_id, $payer_id)
    {
        $payment = $this->gateway
            ->completePurchase([
                'payerId' => $payer_id,
                'transactionReference' => $payment_id,
            ])
            ->send();

        if ($payment->isSuccessful()) {
            return [
                'status' => 'success',
                'payment_response' => $payment->getData(),
                'notes' => 'Payment successful',
            ];
        }
        return [
            'status' => 'failed',
            'payment_response' => $payment->getData(),
            'notes' => $payment->getMessage(),
        ];
    }
}
