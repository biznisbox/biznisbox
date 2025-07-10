<?php

namespace App\Services\ClientPortal;

use App\Models\Contract;

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
        createActivityLog('retrieve', null, 'App\Models\Contract', 'Contract', auth()->id(), 'App\Models\User', 'client_portal');
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

        createActivityLog('retrieve', $id, 'App\Models\Contract', 'Contract', auth()->id(), 'App\Models\User', 'client_portal');
        return $contract;
    }
}
