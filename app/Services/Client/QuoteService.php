<?php

namespace App\Services\Client;

use App\Models\Quote;
use App\Models\ExternalKeys;

class QuoteService
{
    public function getQuote($key)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'quote')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'quote');
            $quote = new Quote();
            $quote = $quote->getClientQuote($key_data->module_item_id);

            if (!$quote) {
                return api_response(false, __('response.estimate.not_found'));
            }
            activity_log(null, 'clientGetEstimate', $key_data->module_item_id, 'App\Models\Estimate', 'ClientEstimate', 'external', $key);
            return api_response($quote, __('response.success'));
        } else {
            return api_response(null, __('response.estimate.not_found'), 404);
        }
    }

    public function acceptRejectQuote($key, $data)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'quote')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'quote');
            $quote = new Quote();
            $quote = $quote->clientAcceptRejectQuote($key_data->module_item_id, $data);

            if (!$quote) {
                return api_response(false, __('response.estimate.not_found'));
            }
            activity_log(
                null,
                'clientAcceptRejectEstimate',
                $key_data->module_item_id,
                'App\Models\Estimate',
                'ClientEstimate',
                'external',
                $key
            );
            return api_response($quote, __('response.success'));
        }

        return api_response(null, __('response.estimate.not_found'), 404);
    }
}
