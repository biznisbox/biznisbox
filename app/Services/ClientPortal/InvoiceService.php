<?php

namespace App\Services\ClientPortal;

use App\Models\Invoice;

class InvoiceService
{
    public function getInvoices()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $invoices = Invoice::where('payer_id', $partner_id)->orWhere('customer_id', $partner_id)->get();

        return $invoices;
    }

    public function getInvoiceById($invoiceId)
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $invoice = Invoice::with(['items', 'paymentMethod', 'salesPerson'])
            ->where('id', $invoiceId)
            ->where(function ($query) use ($partner_id) {
                $query->where('payer_id', $partner_id)->orWhere('customer_id', $partner_id);
            })
            ->first();

        // remove notes
        if ($invoice) {
            $invoice->notes = null;
        }

        return $invoice;
    }
}
