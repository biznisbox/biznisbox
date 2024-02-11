<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceModel;
    public function __construct(Invoice $invoiceModel)
    {
        $this->invoiceModel = $invoiceModel;
    }

    public function getInvoices()
    {
        $invoices = $this->invoiceModel->getInvoices();
        return api_response($invoices, __('response.invoice.get_success'), 200);
    }

    public function getInvoice($id)
    {
        $invoice = $this->invoiceModel->getInvoice($id);

        if ($invoice) {
            return api_response($invoice, __('response.invoice.get_success'), 200);
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }

    public function createInvoice(Request $request)
    {
        $invoiceData = $request->all();
        $invoice = $this->invoiceModel->createInvoice($invoiceData);

        if ($invoice) {
            return api_response($invoice, __('response.invoice.create_success'), 201);
        }
        return api_response(null, __('response.invoice.create_failed'), 400);
    }

    public function updateInvoice(Request $request, $id)
    {
        $invoiceData = $request->all();
        $invoice = $this->invoiceModel->updateInvoice($id, $invoiceData);

        if ($invoice) {
            return api_response($invoice, __('response.invoice.update_success'), 200);
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }

    public function deleteInvoice($id)
    {
        $invoice = $this->invoiceModel->deleteInvoice($id);

        if ($invoice) {
            return api_response($invoice, __('response.invoice.delete_success'), 200);
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }

    public function getInvoiceNumber()
    {
        $invoice_number = $this->invoiceModel->getInvoiceNumber();
        return api_response($invoice_number, __('response.invoice.get_success'), 200);
    }

    public function shareInvoice($id)
    {
        $invoice_link = $this->invoiceModel->shareInvoice($id);
        return api_response($invoice_link, __('response.invoice.share_success'), 200);
    }

    public function getInvoicePdf(Request $request)
    {
        $invoice_pdf = $this->invoiceModel->getInvoicePdf($request->id, $request->type);

        if ($invoice_pdf) {
            return $invoice_pdf;
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }

    public function sendInvoice($id)
    {
        $invoice = $this->invoiceModel->sendInvoice($id);

        if ($invoice) {
            return api_response($invoice, __('response.invoice.send_success'), 200);
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }

    public function addTransaction(Request $request, $id)
    {
        $transaction = $this->invoiceModel->addTransaction($id, $request->all());

        if ($transaction) {
            return api_response($transaction, __('response.invoice.transaction_success'), 200);
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }

    public function sendInvoiceNotification($id)
    {
        $invoice = $this->invoiceModel->sendInvoiceNotification($id);

        if ($invoice) {
            return api_response(null, __('response.invoice.notification_success'), 200);
        }
        return api_response(null, __('response.invoice.not_found'), 404);
    }
}
