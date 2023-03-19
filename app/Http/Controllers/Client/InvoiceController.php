<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\InvoiceService;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function getInvoice(Request $request)
    {
        $key = $request->key;
        $invoice = $this->invoiceService->getInvoice($key);

        return $invoice;
    }
}
