<?php

namespace App\Services\Client;

use App\Models\Quote;
use App\Models\ExternalKey;

class QuoteService
{
    public function getQuote($key)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'quote')) {
            $key_data = new ExternalKey();
            $key_data = $key_data->getExternalKey($key, 'quote');
            $quote = new Quote();
            $quote = $quote->getClientQuote($key_data->module_item_id);

            if (!$quote) {
                return false;
            }
            createActivityLog('retrieve', $quote->id, 'App\Models\Quote', 'Quote', null, null, 'external_key', $key);
            return $quote;
        } else {
            return false;
        }
    }

    public function acceptRejectQuote($key, $status)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'quote')) {
            $key_data = new ExternalKey();
            $key_data = $key_data->getExternalKey($key, 'quote');
            $quote = new Quote();
            $quote = $quote->find($key_data->module_item_id);
            if (!$quote) {
                return false;
            }

            if ($quote->valid_until < now()) {
                return [
                    'error' => true,
                    'message' => __('responses.quote_expired'),
                ];
            }
            $quote->status = $status;
            $quote->save();
            return $quote;
        } else {
            return false;
        }
    }
}
