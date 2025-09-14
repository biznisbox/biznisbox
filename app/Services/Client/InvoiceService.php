<?php

namespace App\Services\Client;

use App\Models\Invoice;
use App\Models\ExternalKey;
use App\Services\OnlinePaymentService;
use App\Models\OnlinePayment;

class InvoiceService
{
    public function getInvoice($key)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'invoice')) {
            $key_data = ExternalKey::getExternalKey($key, 'invoice');
            $invoice = Invoice::getClientInvoice($key_data->module_item_id);
            createActivityLog('retrieve', $invoice->id, Invoice::$modelName, 'Invoice', null, null, 'external_key', $key);
            return $invoice;
        }
        return null;
    }

    public function payInvoiceByGateway($key, $paymentGateway)
    {
        if (!$key) {
            return [
                'error' => __('responses.invalid_key'),
            ];
        }

        if (validateExternalKey($key, 'invoice')) {
            $key_data = ExternalKey::getExternalKey($key, 'invoice');
            $invoice = Invoice::getClientInvoice($key_data->module_item_id);

            if (!$invoice || $invoice->status == 'paid') {
                return [
                    'error' => __('responses.invoice_not_found_or_already_paid'),
                ];
            }
            $payment = (new OnlinePaymentService())->payInvoiceWithGateway($invoice, $paymentGateway, $key);
            createActivityLog(
                'onlinePayment_' . strtolower($paymentGateway),
                $invoice->id,
                Invoice::$modelName,
                'Invoice',
                null,
                null,
                'external_key',
                $key,
            );
            return $payment;
        }
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
            null,
            null,
            'payment_id',
            $payment_id,
        );
        return $payment;
    }

    public function getAllAvailablePaymentGateways($key)
    {
        if (!$key) {
            return [
                'error' => __('responses.invalid_key'),
            ];
        }
        if (validateExternalKey($key, 'invoice')) {
            return (new OnlinePaymentService())->getAllAvailablePaymentGateways();
        }
    }
}
