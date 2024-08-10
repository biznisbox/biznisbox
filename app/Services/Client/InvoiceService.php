<?php

namespace App\Services\Client;

use App\Models\Invoice;
use App\Models\ExternalKey;
use App\Services\OnlinePaymentService;

class InvoiceService
{
    public function getInvoice($key)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'invoice')) {
            $key_data = new ExternalKey();
            $key_data = $key_data->getExternalKey($key, 'invoice');
            $invoice = new Invoice();
            $invoice = $invoice->getClientInvoice($key_data->module_item_id);

            if (!$invoice) {
                return false;
            }
            createActivityLog('retrieve', $invoice->id, 'App\Models\Invoice', 'Invoice', null, null, 'external_key', $key);
            return $invoice;
        } else {
            return false;
        }
    }

    public function payInvoiceStripe($key)
    {
        if (!$key) {
            return [
                'error' => true,
                'message' => __('Invalid key'),
            ];
        }

        if (validateExternalKey($key, 'invoice')) {
            $key_data = new ExternalKey();
            $key_data = $key_data->getExternalKey($key, 'invoice');
            $invoice = new Invoice();
            $invoice = $invoice->getClientInvoice($key_data->module_item_id);
            if (!$invoice || $invoice->status == 'paid') {
                return [
                    'error' => true,
                    'message' => __('Invoice not found or already paid'),
                ];
            }
            $payment = (new OnlinePaymentService())->payInvoiceWithStripe($invoice, $key);
            createActivityLog('online_payment_stripe', $invoice->id, 'App\Models\Invoice', 'Invoice', null, null, 'external_key', $key);
            return $payment;
        }
    }

    public function validateInvoiceStripePayment($payment_id)
    {
        if (!$payment_id) {
            return [
                'error' => true,
                'message' => __('responses.invalid_payment_id'),
            ];
        }
        $payment = (new OnlinePaymentService())->validateInvoiceStripePayment($payment_id);
        return $payment;
    }

    public function payInvoicePayPal($key)
    {
        if (!$key) {
            return [
                'error' => true,
                'message' => __('responses.invalid_key'),
            ];
        }

        if (validateExternalKey($key, 'invoice')) {
            $key_data = new ExternalKey();
            $key_data = $key_data->getExternalKey($key, 'invoice');
            $invoice = new Invoice();
            $invoice = $invoice->getClientInvoice($key_data->module_item_id);
            if (!$invoice || $invoice->status == 'paid') {
                return [
                    'error' => true,
                    'message' => __('responses.invoice_not_found_or_already_paid'),
                ];
            }
            $payment = (new OnlinePaymentService())->payInvoiceWithPayPal($invoice, $key);
            createActivityLog('online_payment_paypal', $invoice->id, 'App\Models\Invoice', 'Invoice', null, null, 'external_key', $key);
            return $payment;
        }
    }

    public function validateInvoicePayPalPayment($paymentId, $payerId)
    {
        if (!$paymentId || !$payerId) {
            return [
                'error' => true,
                'message' => __('responses.invalid_payment_id'),
            ];
        }
        $payment = (new OnlinePaymentService())->validateInvoicePayPalPayment($paymentId, $payerId);
        return $payment;
    }
}
