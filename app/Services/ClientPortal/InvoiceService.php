<?php

namespace App\Services\ClientPortal;

use App\Models\Invoice;

class InvoiceService
{
    public function getInvoices()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $invoices = Invoice::where('payer_id', $partner_id)
            ->orWhere('customer_id', $partner_id)
            ->get()
            ?->makeHidden(['notes']);
        createActivityLog('retrieve', null, 'App\Models\Invoice', 'Invoice', auth()->id(), 'App\Models\User', 'client_portal');

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
            ->first()
            ?->makeHidden(['notes']);

        // remove notes
        if ($invoice) {
            $invoice->notes = null;
        }

        createActivityLog('retrieve', $invoiceId, 'App\Models\Invoice', 'Invoice', auth()->id(), 'App\Models\User', 'client_portal');

        return $invoice;
    }
}
