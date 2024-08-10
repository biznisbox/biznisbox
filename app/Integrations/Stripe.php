<?php

namespace App\Integrations;

use Stripe\StripeClient;
use App\Models\Invoice;

class Stripe
{
    private $config;
    private $stripe;
    public function __construct()
    {
        $this->config = settings(['stripe_available', 'stripe_key']);
        $this->stripe = new StripeClient($this->config['stripe_key']);
    }

    /*=============================================
    =            Stripe Checkout                 =
    =============================================*/

    /**
     * Create a checkout session for invoice payment
     *
     * @param Invoice $invoice Invoice to be paid
     * @param array $metadata Metadata to be attached to the session
     * @param string $success_url URL to redirect to if payment is successful
     * @param string $cancel_url URL to redirect to if payment is cancelled
     * @return object $session Checkout stripe session object
     */

    public function createCheckoutForInvoicePayment($invoice, $metadata, $success_url, $cancel_url)
    {
        $session = $this->stripe->checkout->sessions->create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'client_reference_id' => $invoice->id,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $invoice->currency,
                        'product_data' => [
                            'name' => __('Payment for Invoice #:invoice', [
                                'invoice' => $invoice->number,
                            ]),
                        ],
                        'unit_amount' => $invoice->total * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'metadata' => $metadata,
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);
        return $session;
    }

    public function retrievePaymentSession($checkout_session_id)
    {
        $session = $this->stripe->checkout->sessions->retrieve($checkout_session_id);
        return $session;
    }

    public function expirePaymentSession($checkout_session_id)
    {
        $session = $this->stripe->checkout->sessions->expire($checkout_session_id);
        return $session;
    }

    /*=============================================
    =            Stripe Payment Intents          =
    =============================================*/

    public function createPaymentIntent($amount, $currency, $customer_email)
    {
        $intent = $this->stripe->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => $currency,
            'payment_method_types' => ['card'],
            'receipt_email' => $customer_email,
        ]);
        return $intent;
    }

    public function retrievePaymentIntent($payment_intent_id)
    {
        $intent = $this->stripe->paymentIntents->retrieve($payment_intent_id);
        return $intent;
    }

    public function confirmPaymentIntent($payment_intent_id)
    {
        $intent = $this->stripe->paymentIntents->confirm($payment_intent_id);
        return $intent;
    }

    public function cancelPaymentIntent($payment_intent_id)
    {
        $intent = $this->stripe->paymentIntents->cancel($payment_intent_id);
        return $intent;
    }

    public function capturePaymentIntent($payment_intent_id)
    {
        $intent = $this->stripe->paymentIntents->capture($payment_intent_id);
        return $intent;
    }
}
