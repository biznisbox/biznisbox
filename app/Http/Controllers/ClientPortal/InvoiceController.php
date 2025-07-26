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
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($invoices, __('responses.data_retrieved_successfully'));
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
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($invoice, __('responses.data_retrieved_successfully'));
    }
}
