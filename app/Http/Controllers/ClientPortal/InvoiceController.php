<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\InvoiceService;

/**
 * @group Client Portal Invoices
 *
 * APIs for managing invoices in the client portal
 */
class InvoiceController extends Controller
{
    private $invoiceService;
    private $redirectTo = '/client-portal/invoices/';

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Get all invoices from current logged in user in the client portal
     *
     * @return array $invoice Invoice
     * @authenticated
     */
    public function getInvoices()
    {
        $invoices = $this->invoiceService->getInvoices();

        if (!$invoices) {
            return apiResponse(null, __('responses.item_not_found'), 404);
        }

        return apiResponse($invoices, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get invoice by ID
     *
     * @param  string $invoiceId Invoice UUID
     * @return Invoice $invoice Invoice
     * @authenticated
     */
    public function getInvoiceById($invoiceId)
    {
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);

        if (!$invoice) {
            return apiResponse(null, __('responses.item_not_found'), 404);
        }

        return apiResponse($invoice, __('responses.data_retrieved_successfully'));
    }

    /**
     * Pay invoice by payment gateway
     *
     * @param  string $paymentGateway Payment Gateway (stripe, paypal, etc.)
     * @param  string $invoiceId Invoice UUID
     * @return array $payment Payment
     * @authenticated
     */
    public function payInvoiceByGateway(Request $request, $paymentGateway)
    {
        $invoiceId = $request->invoiceId;
        if (!$invoiceId) {
            return apiResponse(null, __('responses.invalid_invoice_id'), 400);
        }

        $payment = $this->invoiceService->payInvoiceByGateway($invoiceId, $paymentGateway);
        return apiResponse($payment);
    }

    /**
     * Validate invoice payment by payment gateway
     *
     * @param  string $paymentGateway Payment Gateway (stripe, paypal, etc.)
     * @param  string $invoiceId Invoice UUID
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
            return redirect($this->redirectTo . $request->invoice . '?status=success');
        }

        if (isset($payment['error']) && $request->method == 'web') {
            return redirect($this->redirectTo . $request->invoice . '?status=error');
        }
        return apiResponse($payment);
    }

    /**
     * Get all available payment gateways
     *
     * @return array $gateways List of available payment gateways
     */
    public function getAllAvailablePaymentGateways()
    {
        $gateways = $this->invoiceService->getAllAvailablePaymentGateways();
        return apiResponse($gateways, __('responses.data_retrieved_successfully'));
    }
}
