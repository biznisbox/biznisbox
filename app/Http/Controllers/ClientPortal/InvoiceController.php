<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\InvoiceService;

class InvoiceController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function getInvoices()
    {
        $invoices = $this->invoiceService->getInvoices();

        if (!$invoices) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($invoices, __('responses.data_retrieved_successfully'));
    }

    public function getInvoiceById($invoiceId)
    {
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);

        if (!$invoice) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($invoice, __('responses.data_retrieved_successfully'));
    }
}
