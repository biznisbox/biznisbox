<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\InvoiceService;

/**
 * @group Client Invoices
 *
 * APIs for managing invoices
 */
class InvoiceController extends Controller
{
    private $invoiceService;

    private $redirectTo = '/client/invoice/';

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Get invoice by key
     *
     * @return array $invoice Invoice
     */
    public function getInvoice(Request $request)
    {
        $key = $request->key;
        $invoice = $this->invoiceService->getInvoice($key);

        if (!$invoice) {
            return apiResponse(null, __('responses.item_not_found'), 404);
        }
        return apiResponse($invoice, __('responses.data_retrieved_successfully'));
    }

    /**
     * Pay invoice by payment gateway
     *
     * @param  string $paymentGateway Payment Gateway (paypal, stripe, razorpay, paystack, flutterwave, mollie, square)
     * @return array $payment Payment Response
     */
    public function payInvoiceByGateway(Request $request, $paymentGateway)
    {
        $key = $request->key;
        if (!$key) {
            return apiResponse(null, __('responses.invalid_key'), 400);
        }

        $payment = $this->invoiceService->payInvoiceByGateway($key, $paymentGateway);
        return apiResponse($payment);
    }

    /**
     * Validate invoice payment by payment gateway
     *
     * @param  string $paymentGateway Payment Gateway (paypal, stripe, razorpay, paystack, flutterwave, mollie, square)
     * @return void redirect to invoice page or return JSON
     */
    public function validateInvoicePaymentByGateway(Request $request, $paymentGateway)
    {
        $payment_id = $request->paymentId ?? $request->cookie('payment_id'); // for Stripe
        $payer_id = $request->PayerID; // for PayPal

        if (!$payment_id) {
            return apiResponse(null, __('responses.invalid_payment_id'), 400);
        }

        $payment = $this->invoiceService->validateInvoicePaymentByGateway($payment_id, $paymentGateway, $payer_id);

        if ($request->method == 'web' && !isset($payment['error'])) {
            return redirect($this->redirectTo . $request->invoice . '?key=' . $request->key . '&status=success');
        }

        if (isset($payment['error']) && $request->method == 'web') {
            return redirect($this->redirectTo . $request->invoice . '?key=' . $request->key . '&status=error');
        }
        return apiResponse($payment);
    }
}
