<?php

namespace App\Services\ClientPortal;

use App\Models\Contract;
use App\Models\User;

class ContractService
{
    private $contractModel;
    public function __construct()
    {
        $this->contractModel = new Contract();
    }

    public function getContracts()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());
        $contracts = $this->contractModel
            ->with('signers', 'category:id,name,color', 'partner:id,name,type,entity_type')
            ->where('partner_id', $partner_id)
            ->get()
            ?->makeHidden(['notes']);
        createActivityLog('retrieve', null, Contract::$modelName, 'Contract', auth()->id(), User::$modelName, 'client_portal');
        return $contracts;
    }

    public function getContract($id)
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());
        $contract = $this->contractModel
            ->with('signers', 'category:id,name,color', 'partner:id,name,type,entity_type')
            ->where('id', $id)
            ->where('partner_id', $partner_id)
            ->first()
            ?->makeHidden(['notes']);

        createActivityLog('retrieve', $id, Contract::$modelName, 'Contract', auth()->id(), User::$modelName, 'client_portal');
        return $contract;
    }
}
