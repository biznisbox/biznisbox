<?php

namespace App\Services\Client;

use App\Models\Estimate;
use App\Models\ExternalKeys;

class EstimateService
{
    public function getEstimate($key)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'estimate')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'estimate');
            $estimate = new Estimate();
            $estimate = $estimate->getClientEstimate($key_data->module_item_id);

            if (!$estimate) {
                return api_response(false, __('response.estimate.not_found'));
            }
            activity_log(null, 'clientGetEstimate', $key_data->module_item_id, 'App\Models\Estimate', 'ClientEstimate', 'external', $key);
            return api_response($estimate, __('response.success'));
        } else {
            return api_response(null, __('response.estimate.not_found'), 404);
        }
    }

    public function acceptRejectEstimate($key, $data)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'estimate')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'estimate');
            $estimate = new Estimate();
            $estimate = $estimate->clientAcceptRejectEstimate($key_data->module_item_id, $data);

            if (!$estimate) {
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
            return api_response($estimate, __('response.success'));
        }

        return api_response(null, __('response.estimate.not_found'), 404);
    }
}
