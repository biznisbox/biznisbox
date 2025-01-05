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
        $this->redirectTo = $this->redirectTo;
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
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($invoice, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Pay invoice with stripe
     * 
     * @param  object  $request data from the form (key)
     * @return array $payment Payment
     */
    public function payInvoiceStripe(Request $request)
    {
        $key = $request->key;
        $payment = $this->invoiceService->payInvoiceStripe($key);

        if (isset($payment['error'])) {
            return api_response(null, $payment['message'], 400);
        }
        return api_response($payment);
    }

    /**
     * Validate invoice stripe payment
     * 
     * @param  object  $request data from the form (invoice, key, method)
     * @return array $payment Payment
     */
    public function validateInvoiceStripePayment(Request $request)
    {
        $session_id = $request->cookie('payment_id');
        $payment = $this->invoiceService->validateInvoiceStripePayment($session_id);

        if ($request->method == 'web' && !isset($payment['error'])) {
            return redirect($this->redirectTo . $request->invoice . '?key=' . $request->key . '&status=success');
        }

        if (isset($payment['error']) && $request->method == 'web') {
            return redirect($this->redirectTo . $request->invoice . '?key=' . $request->key . '&status=error');
        }
        return api_response($payment);
    }

    /**
     * Pay invoice with paypal
     * 
     * @param  object  $request data from the form (key)
     * @return array $payment Payment
     */
    public function payInvoicePayPal(Request $request)
    {
        $key = $request->key;
        $payment = $this->invoiceService->payInvoicePayPal($key);

        if (isset($payment['error'])) {
            return api_response(null, $payment['message'], 400);
        }
        return api_response($payment);
    }

    /**
     * Validate invoice paypal payment
     * 
     * @param  object  $request data from the form (invoice, key, method)
     * @return array $payment Payment
     */
    public function validateInvoicePayPalPayment(Request $request)
    {
        $payment_id = $request->paymentId;
        $payer_id = $request->PayerID;

        $payment = $this->invoiceService->validateInvoicePayPalPayment($payment_id, $payer_id);

        if ($request->method == 'web' && !isset($payment['error'])) {
            return redirect($this->redirectTo . $request->invoice . '?key=' . $request->key . '&status=success');
        }

        if (isset($payment['error']) && $request->method == 'web') {
            return redirect($this->redirectTo . $request->invoice . '?key=' . $request->key . '&status=error');
        }

        return api_response($payment);
    }
}
