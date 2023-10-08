<?php

namespace App\Services;

use Stripe\StripeClient;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\ExternalKeys;
use App\Models\OnlinePayment;
use Omnipay\Omnipay;

class OnlinePaymentService
{
    public function __construct()
    {
        //
    }

    public function makeStripePayment($request)
    {
        if (!settings('stripe_available')) {
            return api_response(false, __('response.payment.stripe_not_available'), 400);
        }

        $type = $request->type ?? 'api';

        $stripe = new StripeClient(settings('stripe_key'));

        $key = $request->key;

        if (validate_external_key($key, 'invoice')) {
            $key_data = ExternalKeys::where('key', $key)->first();
            $invoice = Invoice::find($key_data->module_item_id);

            if (!$invoice) {
                return api_response(false, __('response.invoice.not_found'));
            }

            if ($invoice->status == 'paid') {
                return api_response(null, __('response.payment.already_paid'), 400);
            }

            $payment = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => url(
                    'api/online_payment/stripe/success?key=' . $key . '&status=success&lang=' . app()->getLocale() . '&type=' . $type
                ),
                'cancel_url' => url(
                    'api/online_payment/stripe/cancel?key=' . $key . '&status=cancel&lang=' . app()->getLocale() . '&type=' . $type
                ),
                'payment_method_types' => ['card'],
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'key' => $key,
                ],
                'line_items' => [
                    [
                        'name' => __('response.payment.invoice') . ' ' . $invoice->number,
                        'amount' => $invoice->total * 100,
                        'currency' => $invoice->currency,
                        'quantity' => 1,
                    ],
                ],
            ]);

            $online_payment = OnlinePayment::create([
                'payment_method' => 'stripe',
                'payment_id' => $payment->id,
                'payment_status' => $payment->payment_status,
                'payment_response' => $payment,
                'payment_type' => 'online',
                'payment_amount' => $invoice->total,
                'payment_currency' => $invoice->currency,
                'key' => $key,
            ]);

            activity_log(null, 'payment stripe', $online_payment->id, 'Online Payment', 'payment stripe', 'external', $key);

            return response()
                ->json($payment)
                ->cookie('payment_session_id', $payment->id, 60);
        }
        return api_response(false, __('response.invalid_key'), 400);
    }

    // Validate payment with Stripe
    public function validateStripePayment($request, $status)
    {
        if (!settings('stripe_available')) {
            return api_response(false, __('response.payment.stripe_not_available'), 400);
        }

        $key = $request->key;

        if (validate_external_key($key, 'invoice')) {
            $key_data = ExternalKeys::where('key', $key)->first();
            $invoice = Invoice::find($key_data->module_item_id);

            if (!$invoice) {
                return api_response(false, __('response.invoice.not_found'));
            }

            $payment = OnlinePayment::where('key', $key)
                ->latest()
                ->first();

            if (!$payment) {
                return api_response(false, __('response.payment.not_found'), 400);
            }

            $stripe = new StripeClient(settings('stripe_key'));

            $session = $stripe->checkout->sessions->retrieve($payment->payment_id, []);

            if ($session->payment_status == 'paid') {
                $payment->payment_status = 'success';
                $payment->payment_amount = $session->amount_total / 100;
                $payment->payment_currency = $session->currency;
                $payment->save();

                $transaction = Transaction::create([
                    'name' => __('response.payment.invoice') . ' ' . $invoice->number,
                    'invoice_id' => $invoice->id,
                    'payment_id' => $payment->id,
                    'amount' => $invoice->total,
                    'customer_id' => $invoice->customer_id,
                    'currency' => $invoice->currency,
                    'exchange_rate' => $invoice->currency_rate,
                    'payment_method' => 'stripe',
                    'payment_status' => 'success',
                    'type' => 'income',
                    'number' => Transaction::getTransactionNumber(),
                    'date' => date('Y-m-d'),
                    'referenced_online_payment' => $payment->id,
                ]);

                $invoice->status = 'paid';
                $invoice->save();

                activity_log(null, 'validate payment stripe', $payment->id, 'Online Payment', 'payment stripe', 'external', $key);

                if ($request->type == 'web') {
                    return redirect('client/invoice/' . $invoice->id . '?key=' . $key . '&status=success&lang=' . app()->getLocale());
                }
                return api_response(true, __('response.payment.success'));
            }

            if ($request->type == 'web') {
                return redirect('client/invoice/' . $invoice->id . '?key=' . $key . '&status=error&lang=' . app()->getLocale());
            }
            return api_response(false, __('response.payment.failed'), 400);
        }
    }

    public function makePaypalPayment($request)
    {
        if (!settings('paypal_available')) {
            return api_response(false, __('response.payment.paypal_not_available'), 400);
        }
        $key = $request->key;
        $type = $request->type ?? 'api';

        if (validate_external_key($key, 'invoice')) {
            $key_data = ExternalKeys::where('key', $key)->first();
            $invoice = Invoice::find($key_data->module_item_id);

            if (!$invoice) {
                return api_response(false, __('response.invoice.not_found'));
            }

            if ($invoice->status == 'paid') {
                return api_response(null, __('response.payment.already_paid'), 400);
            }

            $gateway = Omnipay::create('PayPal_Rest');

            $gateway->initialize([
                'clientId' => settings('paypal_client_id'),
                'secret' => settings('paypal_secret'),
                'testMode' => settings('paypal_test_mode'),
            ]);

            $transaction = $gateway
                ->purchase([
                    'amount' => $invoice->total,
                    'currency' => $invoice->currency,
                    'description' => __('response.payment.invoice') . ' ' . $invoice->number,
                    'returnUrl' => url(
                        'api/online_payment/paypal/success?key=' . $key . '&status=success&lang=' . app()->getLocale() . '&type=' . $type
                    ),
                    'cancelUrl' => url(
                        'api/online_payment/paypal/cancel?key=' . $key . '&status=cancel&lang=' . app()->getLocale() . '&type=' . $type
                    ),
                ])
                ->send();

            if ($transaction->isRedirect()) {
                $payment = $transaction->getData();

                OnlinePayment::create([
                    'payment_method' => 'paypal',
                    'payment_id' => $payment['id'],
                    'payment_status' => $payment['state'],
                    'payment_response' => $payment,
                    'payment_type' => 'online',
                    'payment_amount' => $invoice->total,
                    'payment_currency' => $invoice->currency,
                    'key' => $key,
                ]);

                activity_log(null, 'payment paypal', $payment['id'], 'Online Payment', 'payment paypal', 'external', $key);
                return response()
                    ->json(['url' => $transaction->getRedirectUrl()])
                    ->cookie('payment_session_id', $payment['id'], 60);
            }
            return api_response(false, __('response.payment.failed'), 400);
        }
        return api_response(false, __('response.invalid_key'), 400);
    }

    public function validatePaypalPayment($request, $status)
    {
        if (!settings('paypal_available')) {
            return api_response(false, __('response.payment.paypal_not_available'), 400);
        }
        $key = $request->key;

        if (validate_external_key($key, 'invoice')) {
            $key_data = ExternalKeys::where('key', $key)->first();
            $invoice = Invoice::find($key_data->module_item_id);

            if ($status == 'cancel') {
                if ($request->type == 'web') {
                    return redirect('client/invoice/' . $invoice->id . '?key=' . $key . '&status=error&lang=' . app()->getLocale());
                }
                return api_response(false, __('response.payment.cancelled'), 400);
            }

            $payment = OnlinePayment::where('key', $key)
                ->latest()
                ->first();

            if (!$payment) {
                return api_response(false, __('response.payment.not_found'), 400);
            }

            $gateway = Omnipay::create('PayPal_Rest');

            $gateway->initialize([
                'clientId' => settings('paypal_client_id'),
                'secret' => settings('paypal_secret'),
                'testMode' => settings('paypal_test_mode'),
            ]);

            $transaction = $gateway
                ->completePurchase([
                    'payer_id' => $request->PayerID,
                    'transactionReference' => $payment->payment_id,
                ])
                ->send();

            if ($transaction->isSuccessful()) {
                $payment->payment_status = 'success';
                $payment->save();

                $transaction = Transaction::create([
                    'name' => __('response.payment.invoice') . ' ' . $invoice->number,
                    'invoice_id' => $invoice->id,
                    'amount' => $invoice->total,
                    'customer_id' => $invoice->customer_id,
                    'currency' => $invoice->currency,
                    'exchange_rate' => $invoice->currency_rate,
                    'payment_method' => 'paypal',
                    'payment_status' => 'success',
                    'type' => 'income',
                    'number' => Transaction::getTransactionNumber(),
                    'date' => date('Y-m-d'),
                    'referenced_online_payment' => $payment->id,
                ]);

                $invoice->status = 'paid';
                $invoice->save();

                activity_log(null, 'validate payment paypal', $payment->id, 'Online Payment', 'payment paypal', 'external', $key);

                if ($request->type == 'web') {
                    return redirect('client/invoice/' . $invoice->id . '?key=' . $key . '&status=success&lang=' . app()->getLocale());
                }
                return api_response(true, __('response.payment.success'));
            }

            if ($request->type == 'web') {
                return redirect('client/invoice/' . $invoice->id . '?key=' . $key . '&status=error&lang=' . app()->getLocale());
            }
            return api_response(false, __('response.payment.failed'), 400);
        }
    }
}
