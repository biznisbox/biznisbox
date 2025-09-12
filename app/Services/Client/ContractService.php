<?php

namespace App\Services\Client;

use App\Models\Contract;
use App\Models\ExternalKey;

class ContractService
{
    public function getContract($key = null)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'contract')) {
            $key_data = ExternalKey::getExternalKey($key, 'contract');
            $contract = Contract::getClientContract($key_data->module_item_id);
            $contract->must_sign = $contract->checkIfSignerIsSignContract($contract->id, $key_data->id);

            createActivityLog('retrievePublic', $contract->id, Contract::$modelName, 'Contract', null, null, 'external_key', $key);

            if (!$contract) {
                return [
                    'error' => __('responses.item_not_found'),
                ];
            }
            createActivityLog('retrieve', $contract->id, Contract::$modelName, 'Contract', null, null, 'external_key', $key);
            return $contract;
        } else {
            return [
                'error' => __('responses.invalid_key'),
            ];
        }
    }

    public function signContract($key = null, $data)
    {
        if (!$key || !$data) {
            return null;
        }

        if (validateExternalKey($key, 'contract')) {
            $key_data = new ExternalKey();
            $key_data = $key_data->getExternalKey($key, 'contract');
            $contract = new Contract();
            $contract = $contract->signContract($key_data->module_item_id, $key_data->id, $data);
            createActivityLog('sign', $contract->id, Contract::$modelName, 'Contract', null, null, 'external_key', $key);

            if (!$contract) {
                return [
                    'error' => __('responses.item_not_found'),
                ];
            }
            return $contract;
        } else {
            return [
                'error' => __('responses.invalid_key'),
            ];
        }
    }
}
