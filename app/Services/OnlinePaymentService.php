<?php

namespace App\Services;

use App\Enum\PaymentGatewayEnum;
use App\Models\OnlinePayment;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Integrations\Stripe;
use App\Integrations\PayPal;
use App\Integrations\Coinbase;
use App\Models\Category;

class OnlinePaymentService
{
    private const URL_CLIENT_REDIRECT = '/api/client/online-payment/invoice/';
    private const URL_CLIENT_PORTAL_REDIRECT = '/api/client-portal/online-payment/invoice/';

    public function payInvoiceWithStripe($invoice, $key = null, $method = 'web', $type = 'client')
    {
        $payment_session = (new Stripe())->createCheckoutForInvoicePayment(
            $invoice,
            [
                'invoice_id' => $invoice->id,
                'key' => $key,
            ],
            self::generateSuccessUrl($invoice, $key, $method, 'stripe', $type),
            self::generateCancelUrl($invoice, $key, $method, 'stripe', $type),
        );

        $payment = self::createInvoiceOnlinePayment($invoice, $payment_session, $payment_session->id, 'stripe', $key);

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
            // Update payment status to paid
            self::setOnlinePaymentStatus($payment->id, 'paid', $payment_session, $payment_session->payment_intent);

            $invoice = Invoice::find($payment->payment_document_id);

            $payment_method = self::getPaymentMethod('stripe');

            $invoice->update([
                'status' => 'paid',
                'payment_method_id' => $payment_method->id ?? null,
            ]);

            $transaction = self::createInvoicePaymentTransaction($invoice, $payment, $payment_method);

            self::sendNotificationToSalesPerson($invoice);

            self::sendWebhookForSuccessfulPayment($payment_method, $payment, $invoice, $transaction);

            return [
                'data' => $transaction,
                'message' => __('responses.payment_successful'),
            ];
        }

        self::setOnlinePaymentStatus($payment_id, 'failed', $payment_session);

        return [
            'error' => true,
            'data' => $payment_session,
            'message' => __('responses.payment_failed'),
        ];
    }

    /**
     * Create PayPal payment for invoice
     *
     * @param Invoice $invoice Invoice to be paid
     * @param string|null $key Unique key to identify the payment
     * @param string $method Method of payment (web or mobile)
     * @return array
     */
    public function payInvoiceWithPayPal($invoice, $key = null, $method = 'web', $type = 'client')
    {
        $payment_session = (new PayPal())->createCheckoutForInvoicePayment(
            $invoice,
            [
                'invoice_id' => $invoice->id,
                'key' => $key,
            ],
            self::generateSuccessUrl($invoice, $key, $method, 'paypal', $type),
            self::generateCancelUrl($invoice, $key, $method, 'paypal', $type),
        );

        $payment = self::createInvoiceOnlinePayment($invoice, $payment_session, $payment_session['id'], 'paypal', $key);

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
        if (!$payment_id || !$payer_id) {
            return [
                'error' => __('responses.invalid_payment_id'),
            ];
        }

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

            $transaction = self::createInvoicePaymentTransaction($invoice, $online_payment, $payment_method);

            self::sendNotificationToSalesPerson($invoice);

            self::sendWebhookForSuccessfulPayment($payment_method, $online_payment, $invoice, $transaction);

            return [
                'data' => $transaction,
                'message' => __('responses.payment_successful'),
            ];
        }

        self::setOnlinePaymentStatus($payment_id, 'failed', $payment['payment_response']);

        return $payment;
    }

    public function payInvoiceWithCoinbase($invoice, $key = null, $method = 'web', $type = 'client')
    {
        $payment_session = (new Coinbase())->createCharge([
            'name' => 'Invoice ' . $invoice->number,
            'description' => 'Payment for invoice ' . $invoice->number,
            'local_price' => [
                'amount' => number_format($invoice->total, 2, '.', ''),
                'currency' => $invoice->currency,
            ],
            'pricing_type' => 'fixed_price',
            'metadata' => [
                'custom_field' => $invoice->id,
                'custom_field_two' => $key,
            ],
            'redirect_url' => self::generateSuccessUrl($invoice, $key, $method, 'coinbase', $type),
            'cancel_url' => self::generateCancelUrl($invoice, $key, $method, 'coinbase', $type),
        ]);

        $payment = self::createInvoiceOnlinePayment($invoice, $payment_session, $payment_session['data']['id'], 'coinbase', $key);

        return [
            'payment_id' => $payment->id,
            'redirect_url' => $payment_session['data']['hosted_url'], // Redirect to this URL to complete payment
            'payment_session' => $payment_session,
        ];
    }

    public function validateInvoiceCoinbasePayment($payment_id)
    {
        $payment = OnlinePayment::find($payment_id);
        if (!$payment) {
            return [
                'error' => true,
                'message' => __('responses.invalid_payment_id'),
            ];
        }
        $payment_session = (new Coinbase())->getCharge($payment->payment_id);

        if (
            $payment_session['data']['timeline'][count($payment_session['data']['timeline']) - 1]['status'] == 'COMPLETED' &&
            $payment->status !== 'paid'
        ) {
            // Update payment status to paid
            self::setOnlinePaymentStatus(
                $payment->id,
                'paid',
                $payment_session,
                $payment_session['data']['payments'][0]['network_transaction_id'] ?? null,
            );

            $invoice = Invoice::find($payment->payment_document_id);

            $payment_method = self::getPaymentMethod('coinbase');

            $invoice->update([
                'status' => 'paid',
                'payment_method_id' => $payment_method->id ?? null,
            ]);

            $transaction = self::createInvoicePaymentTransaction($invoice, $payment, $payment_method);

            self::sendNotificationToSalesPerson($invoice);

            self::sendWebhookForSuccessfulPayment($payment_method, $payment, $invoice, $transaction);

            return [
                'data' => $transaction,
                'message' => __('responses.payment_successful'),
            ];
        }

        self::setOnlinePaymentStatus($payment_id, 'failed', $payment_session);

        return [
            'error' => true,
            'data' => $payment_session,
            'message' => __('responses.payment_failed'),
        ];
    }

    private static function getPaymentMethod($method)
    {
        return Category::where([
            'module' => 'payment_method',
            'additional_info' => $method,
        ])->first();
    }

    private function generateSuccessUrl($invoice, $key, $method, $paymentGateway, $type = 'client')
    {
        switch ($type) {
            case 'client':
                return url(
                    self::URL_CLIENT_REDIRECT .
                        $paymentGateway .
                        '?invoice=' .
                        $invoice->id .
                        '&key=' .
                        $key .
                        '&status=success&method=' .
                        $method,
                );
            case 'client_portal':
                return url(
                    self::URL_CLIENT_PORTAL_REDIRECT . $paymentGateway . '?invoice=' . $invoice->id . '&status=success&method=' . $method,
                );
            default:
                return url(
                    self::URL_CLIENT_REDIRECT .
                        $paymentGateway .
                        '?invoice=' .
                        $invoice->id .
                        '&key=' .
                        $key .
                        '&status=success&method=' .
                        $method,
                );
        }
    }

    private function generateCancelUrl($invoice, $key, $method, $paymentGateway, $type = 'client')
    {
        switch ($type) {
            case 'client':
                return url(
                    self::URL_CLIENT_REDIRECT .
                        $paymentGateway .
                        '?invoice=' .
                        $invoice->id .
                        '&key=' .
                        $key .
                        '&status=cancel&method=' .
                        $method,
                );
            case 'client_portal':
                return url(
                    self::URL_CLIENT_PORTAL_REDIRECT . $paymentGateway . '?invoice=' . $invoice->id . '&status=cancel&method=' . $method,
                );
            default:
                return url(
                    self::URL_CLIENT_REDIRECT .
                        $paymentGateway .
                        '?invoice=' .
                        $invoice->id .
                        '&key=' .
                        $key .
                        '&status=cancel&method=' .
                        $method,
                );
        }
    }

    /**
     * Create online payment for invoice
     *
     * @param Invoice $invoice
     * @param object|array $payment_session
     * @param string $payment_id
     * @param string $payment_method
     * @param string|null $key
     * @return OnlinePayment
     */
    private static function createInvoiceOnlinePayment($invoice, $payment_session, $payment_id, $payment_method, $key = null)
    {
        $payment = OnlinePayment::create([
            'number' => OnlinePayment::getPaymentNumber(),
            'payment_method' => $payment_method,
            'payment_id' => $payment_id,
            'type' => 'online',
            'amount' => $invoice->total,
            'currency' => $invoice->currency,
            'description' => $invoice->number,
            'status' => 'pending',
            'payment_response' => $payment_session,
            'payment_document_type' => Invoice::$modelName,
            'payment_document_id' => $invoice->id,
            'key' => $key,
        ]);
        incrementLastItemNumber('payment', settings('payment_number_format'));
        return $payment;
    }

    /**
     * Create transaction for invoice payment
     *
     * @param Invoice $invoice
     * @param OnlinePayment $payment
     * @param PaymentMethod $payment_method
     * @return Transaction $transaction
     */
    private static function createInvoicePaymentTransaction($invoice, $payment, $payment_method)
    {
        $transaction = Transaction::create([
            'number' => Transaction::getTransactionNumber(),
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'payment_id' => $payment->id,
            'type' => 'income',
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'description' => $payment->description,
            'status' => 'completed',
            'reference' => $payment->payment_ref,
            'date' => date('Y-m-d'),
            'payment_method_id' => $payment_method->id ?? null,
            'to_account' => settings($payment_method->additional_info . '_account_id') ?? null,
        ]);

        incrementLastItemNumber('transaction', settings('transaction_number_format'));

        return $transaction;
    }

    private static function sendNotificationToSalesPerson($invoice)
    {
        createNotification(
            getUserIdFromEmployeeId($invoice->sales_person_id),
            'InvoicePayment',
            'InvoicePaymentReceived',
            'info',
            'view',
            'invoices/' . $invoice->id,
        );
    }

    private static function setOnlinePaymentStatus($payment_id, $status, $response = null, $ref = null)
    {
        $payment = OnlinePayment::find($payment_id);
        $payment->update([
            'status' => $status,
            'payment_response' => $response,
            'payment_ref' => $ref,
        ]);
        return $payment;
    }

    private static function sendWebhookForSuccessfulPayment($payment_method, $payment, $invoice, $transaction)
    {
        sendWebhookForEvent('online_payment:received', [
            'payment_id' => $payment->id,
            'invoice_id' => $invoice->id,
            'transaction_id' => $transaction->id,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'payment_method' => $payment_method,
            'payment' => $payment,
            'invoice' => $invoice,
            'transaction' => $transaction,
        ]);
    }

    public function payInvoiceWithGateway($invoice, $paymentGateway, $key = null, $type = 'client', $method = 'web')
    {
        $result = null;
        switch ($paymentGateway) {
            case 'stripe':
                $result = $this->payInvoiceWithStripe($invoice, $key, $method, $type);
                break;
            case 'paypal':
                $result = $this->payInvoiceWithPayPal($invoice, $key, $method, $type);
                break;
            case 'coinbase':
                $result = $this->payInvoiceWithCoinbase($invoice, $key, $method, $type);
                break;
            default:
                $result = [
                    'error' => __('responses.payment_gateway_not_supported'),
                ];
                break;
        }
        return $result;
    }

    public function validateInvoicePaymentByGateway($paymentGateway, $payment_id, $payer_id = null)
    {
        $result = null;
        switch ($paymentGateway) {
            case 'stripe':
                $result = $this->validateInvoiceStripePayment($payment_id);
                break;
            case 'paypal':
                $result = $this->validateInvoicePayPalPayment($payment_id, $payer_id);
                break;
            case 'coinbase':
                $result = $this->validateInvoiceCoinbasePayment($payment_id);
                break;
            default:
                $result = [
                    'error' => __('responses.payment_gateway_not_supported'),
                ];
                break;
        }
        return $result;
    }

    public static function checkAllCoinbasePaymentStatus()
    {
        $pendingPayments = OnlinePayment::where('payment_method', 'coinbase')->where('status', 'pending')->get();
        foreach ($pendingPayments as $payment) {
            (new self())->validateInvoiceCoinbasePayment($payment->id);
        }
    }

    public static function getAllAvailablePaymentGateways()
    {
        $paymentGateways = PaymentGatewayEnum::toArray();

        $available_gateways = [];
        foreach ($paymentGateways as $gateway) {
            if (settings("{$gateway}_available")) {
                $available_gateways[] = self::getPaymentMethod($gateway);
            }
        }
        return $available_gateways;
    }
}
