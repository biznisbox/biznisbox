<?php

namespace App\Services\ClientPortal;

use App\Models\Invoice;
use App\Models\User;
use App\Services\OnlinePaymentService;
use App\Models\OnlinePayment;

class InvoiceService
{
    public function getInvoices()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $invoices = Invoice::where('payer_id', $partner_id)
            ->orWhere('customer_id', $partner_id)
            ->get()
            ?->makeHidden(['notes']);
        createActivityLog('retrieve', null, Invoice::$modelName, 'Invoice', auth()->id(), User::$modelName, 'client_portal');

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

        createActivityLog('retrieve', $invoiceId, Invoice::$modelName, 'Invoice', auth()->id(), User::$modelName, 'client_portal');

        return $invoice;
    }

    public function payInvoiceByGateway($invoiceId, $paymentGateway)
    {
        if (!$invoiceId) {
            return [
                'error' => __('responses.invalid_invoice_id'),
            ];
        }

        $partner_id = getPartnerIdFromUserId(auth()->id());

        $invoice = Invoice::with(['items', 'paymentMethod', 'salesPerson'])
            ->where('id', $invoiceId)
            ->where(function ($query) use ($partner_id) {
                $query->where('payer_id', $partner_id)->orWhere('customer_id', $partner_id);
            })
            ->first()
            ?->makeHidden(['notes']);

        if (!$invoice || $invoice->status == 'paid') {
            return [
                'error' => __('responses.invoice_not_found_or_already_paid'),
            ];
        }
        $payment = (new OnlinePaymentService())->payInvoiceWithGateway($invoice, $paymentGateway, null, 'client_portal');
        createActivityLog(
            'onlinePayment_' . strtolower($paymentGateway),
            $invoice->id,
            Invoice::$modelName,
            'Invoice',
            auth()->id(),
            User::$modelName,
            'client_portal',
        );
        return $payment;
    }

    public function validateInvoicePaymentByGateway($payment_id, $paymentGateway, $payer_id = null)
    {
        if (!$payment_id) {
            return [
                'error' => __('responses.invalid_payment_id'),
            ];
        }
        $payment = (new OnlinePaymentService())->validateInvoicePaymentByGateway($paymentGateway, $payment_id, $payer_id);
        createActivityLog(
            'validate_' . strtolower($paymentGateway) . '_payment',
            $payment['data']->id ?? null,
            OnlinePayment::$modelName,
            'OnlinePayment',
            auth()->id(),
            User::$modelName,
            'client_portal',
        );
        return $payment;
    }
}
