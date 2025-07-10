<?php

namespace App\Services;

use App\Models\OnlinePayment;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Integrations\Stripe;
use App\Integrations\PayPal;
use App\Models\Category;

class OnlinePaymentService
{
    public function payInvoiceWithStripe($invoice, $key = null, $method = 'web')
    {
        $payment_session = (new Stripe())->createCheckoutForInvoicePayment(
            $invoice,
            [
                'invoice_id' => $invoice->id,
                'key' => $key,
            ],
            url('/api/online-payment/invoice/stripe?invoice=' . $invoice->id . '&key=' . $key . '&status=success&method=' . $method),
            url('/api/online-payment/invoice/stripe?invoice=' . $invoice->id . '&key=' . $key . '&status=cancel&method=' . $method)
        );

        $payment = OnlinePayment::create([
            'number' => OnlinePayment::getPaymentNumber(),
            'payment_method' => 'stripe',
            'payment_id' => $payment_session->id,
            'type' => 'online',
            'amount' => $invoice->total,
            'currency' => $invoice->currency,
            'description' => $invoice->number,
            'status' => 'pending',
            'payment_response' => $payment_session,
            'payment_document_type' => 'App\Models\Invoice',
            'payment_document_id' => $invoice->id,
            'key' => $key, // this is used to identify the external access token
        ]);

        incrementLastItemNumber('payment');

        return [
            'payment_id' => $payment->id,
            'redirect_url' => $payment_session->url, // Redirect to this URL to complete payment
            'payment_session' => $payment_session,
        ];
    }

    public function validateInvoiceStripePayment($payment_id)
    {
        $payment = OnlinePayment::find($payment_id);
        if (!$payment) {
            return [
                'error' => true,
                'message' => __('responses.invalid_payment_id'),
            ];
        }
        $payment_session = (new Stripe())->retrievePaymentSession($payment->payment_id);

        if ($payment_session->payment_status == 'paid' && $payment !== 'paid') {
            $payment->update([
                'status' => 'paid',
                'payment_response' => $payment_session,
                'payment_ref' => $payment_session->payment_intent,
            ]);

            $invoice = Invoice::find($payment->payment_document_id);

            $payment_method = self::getPaymentMethod('stripe');

            $invoice->update([
                'status' => 'paid',
                'payment_method_id' => $payment_method->id ?? null,
            ]);

            $transaction = Transaction::create([
                'number' => Transaction::getTransactionNumber(),
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'type' => 'income',
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'description' => $payment->description,
                'status' => 'completed',
                'payment_id' => $payment->id,
                'reference' => $payment_session->payment_intent,
                'date' => date('Y-m-d'),
                'payment_method_id' => $payment_method->id,
            ]);

            incrementLastItemNumber('transaction');
            createNotification(
                getUserIdFromEmployeeId($invoice->sales_person_id),
                'InvoicePayment',
                'InvoicePaymentReceived',
                'info',
                'view',
                'invoices/' . $invoice->id
            );

            sendWebhookForEvent('online_payment:stripe-received', [
                'payment_id' => $payment->id,
                'invoice_id' => $invoice->id,
                'transaction_id' => $transaction->id,
            ]);

            return [
                'data' => $transaction,
                'message' => __('responses.payment_successful'),
            ];
        }

        OnlinePayment::where('id', $payment_id)->update([
            'status' => 'failed',
            'payment_response' => $payment_session,
        ]);

        return [
            'error' => true,
            'data' => $payment_session,
            'message' => __('responses.payment_failed'),
        ];
    }

    public function payInvoiceWithPayPal($invoice, $key = null, $method = 'web')
    {
        $payment_session = (new PayPal())->createCheckoutForInvoicePayment(
            $invoice,
            [
                'invoice_id' => $invoice->id,
                'key' => $key,
            ],
            url('/api/online-payment/invoice/paypal?invoice=' . $invoice->id . '&key=' . $key . '&status=success&method=' . $method),
            url('/api/online-payment/invoice/paypal?invoice=' . $invoice->id . '&key=' . $key . '&status=cancel&method=' . $method)
        );

        $payment = OnlinePayment::create([
            'number' => OnlinePayment::getPaymentNumber(),
            'payment_method' => 'paypal',
            'payment_id' => $payment_session['id'],
            'type' => 'online',
            'amount' => $invoice->total,
            'currency' => $invoice->currency,
            'description' => $invoice->number,
            'status' => 'pending',
            'payment_response' => $payment_session,
            'payment_document_type' => 'App\Models\Invoice',
            'payment_document_id' => $invoice->id,
            'key' => $key,
        ]);

        incrementLastItemNumber('payment');

        return [
            'payment_id' => $payment['id'],
            'redirect_url' => $payment_session['links'][1]['href'], // Redirect to this URL to complete payment
            'payment_session' => $payment_session,
        ];
    }

    /**
     * Validate PayPal payment
     *
     * @param string $payment_id  Payment ID from PayPal
     * @param string $payer_id  Payer ID from PayPal
     * @return void
     */
    public function validateInvoicePayPalPayment($payment_id, $payer_id)
    {
        $payment = (new PayPal())->validateInvoicePayPalPayment($payment_id, $payer_id);

        if ($payment['status'] == 'success') {
            $online_payment = OnlinePayment::where('payment_id', $payment_id)->latest()->first();
            $online_payment->update([
                'status' => 'paid',
                'payment_response' => $payment['payment_response'],
                'payment_ref' => $payment['payment_response']['id'],
            ]);

            $invoice = Invoice::find($online_payment->payment_document_id);

            $payment_method = self::getPaymentMethod('paypal');

            $invoice->update([
                'status' => 'paid',
                'payment_method_id' => $payment_method->id ?? null,
            ]);

            $transaction = Transaction::create([
                'number' => Transaction::getTransactionNumber(),
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'type' => 'income',
                'amount' => $online_payment->amount,
                'currency' => $online_payment->currency,
                'description' => $online_payment->description,
                'status' => 'completed',
                'payment_id' => $online_payment->id,
                'reference' => $payment['payment_response']['id'],
                'date' => date('Y-m-d'),
                'payment_method_id' => $payment_method->id ?? null,
            ]);

            incrementLastItemNumber('transaction');
            createNotification(
                getUserIdFromEmployeeId($invoice->sales_person_id),
                'InvoicePayment',
                'InvoicePaymentReceived',
                'info',
                'view',
                'invoices/' . $invoice->id
            );

            sendWebhookForEvent('online_payment:paypal-received', [
                'payment_id' => $online_payment->id,
                'invoice_id' => $invoice->id,
                'transaction_id' => $transaction->id,
            ]);

            return [
                'data' => $transaction,
                'message' => __('responses.payment_successful'),
            ];
        }

        return $payment;
    }

    private function getPaymentMethod($method)
    {
        return Category::where([
            'module' => 'payment_method',
            'additional_info' => $method,
        ])->first();
    }
}
