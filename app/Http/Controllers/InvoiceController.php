<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Services\InvoiceService;

/**
 * @group Invoices
 *
 * APIs for managing invoices
 */
class InvoiceController extends Controller
{
    private $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Get all invoices
     * 
     * @return array $invoices Invoices
     */
    public function getInvoices()
    {
        $invoices = $this->invoiceService->getInvoices();
        if (!$invoices) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($invoices, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get invoice by id
     * 
     * @param  string  $id id of the invoice
     * @return array $invoice Invoice
     */
    public function getInvoice($id)
    {
        $invoice = $this->invoiceService->getInvoice($id);
        if (!$invoice) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($invoice, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create a new invoice
     * 
     * @param  object  $request data from the form
     * @return array $invoice Invoice
     */
    public function createInvoice(InvoiceRequest $request)
    {
        $invoice = $this->invoiceService->createInvoice($request->all());
        if (!$invoice) {
            return api_response(null, __('responses.item_not_created'), 400);
        }
        return api_response($invoice, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update an invoice
     * 
     * @param  object  $request data from the form
     * @param  string  $id id of the invoice
     * @return array $invoice Invoice
     */
    public function updateInvoice(InvoiceRequest $request, $id)
    {
        $invoice = $this->invoiceService->updateInvoice($id, $request->all());
        if (!$invoice) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($invoice, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete an invoice
     * 
     * @param  string  $id id of the invoice
     * @return array $invoice Invoice
     */
    public function deleteInvoice($id)
    {
        $invoice = $this->invoiceService->deleteInvoice($id);
        if (!$invoice) {
            return api_response(null, __('responses.item_not_deleted'), 400);
        }
        return api_response($invoice, __('responses.item_deleted_successfully'), 200);
    }

    /**
     * Get invoice number
     * 
     * @return array $invoice Invoice
     */
    public function getInvoiceNumber()
    {
        $invoice = $this->invoiceService->getInvoiceNumber();
        if (!$invoice) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($invoice, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Share invoice
     * 
     * @param  string  $id id of the invoice
     * @return array $invoice Invoice
     */
    public function shareInvoice($id)
    {
        $invoice = $this->invoiceService->shareInvoice($id);
        if (!$invoice) {
            return api_response(null, __('responses.item_not_shared'), 400);
        }
        return api_response($invoice, __('responses.item_shared_successfully'), 200);
    }

    /**
     * Get invoice pdf
     * 
     * @param  object  $request data from the form
     * @param  string  $id id of the invoice
     * @return array $invoice Invoice
     */
    public function getInvoicePdf(Request $request, $id)
    {
        if (!$request->hasValidSignatureWhileIgnoring(['lang'])) {
            return api_response(null, __('responses.invalid_signature'), 400);
        }
        $type = $request->input('type', 'stream');
        $pdf = $this->invoiceService->getInvoicePdf($id, $type);
        return $pdf;
    }

    /**
     * Add payment to invoice
     * 
     * @param Request $request
     * @param $id Invoice ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInvoicePayment(Request $request, $id)
    {
        $invoice = $this->invoiceService->addInvoicePayment($id, $request->all());
        if (!$invoice) {
            return api_response(null, __('responses.payment_not_added'), 400);
        }
        return api_response($invoice, __('responses.payment_added_successfully'), 200);
    }

    /**
     * Send invoice notification
     * @param Request $request
     * @param $id Invoice ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendInvoiceNotification(Request $request, $id)
    {
        if ($request->has('contact')) {
            $contact = $request->input('contact');
        } else {
            $contact = null;
        }
        $invoice = $this->invoiceService->sendInvoiceNotification($id, $contact);
        if (!$invoice) {
            return api_response(null, __('responses.notification_not_sent'), 400);
        }
        return api_response($invoice, __('responses.notification_sent_successfully'), 200);
    }
}
