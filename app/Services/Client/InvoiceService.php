<?php

namespace App\Services\Client;

use App\Models\Invoice;
use App\Models\ExternalKeys;

class InvoiceService
{
    public function getInvoice($key)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'invoice')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'invoice');
            $invoice = new Invoice();
            $invoice = $invoice->getClientInvoice($key_data->module_item_id);

            if (!$invoice) {
                return api_response(false, __('response.invoice.not_found'));
            }
            activity_log(null, 'clientGetInvoice', $key_data->module_item_id, 'App\Models\Invoice', 'ClientInvoice', 'external', $key);
            return api_response($invoice, __('response.success'));
        } else {
            return api_response(null, __('response.invoice.not_found'), 404);
        }
    }
}
