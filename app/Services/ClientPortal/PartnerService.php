<?php

namespace App\Services\ClientPortal;

use App\Models\Partner;
use App\Models\User;

class PartnerService
{
    public function getPartner()
    {
        $partnerId = getPartnerIdFromUserId(auth()->id());

        $partnerData = Partner::with(['contacts', 'addresses'])
            ->where('id', $partnerId)
            ->first()
            ?->makeHidden(['notes', 'contacts.notes', 'addresses.notes']); // remove notes

        createActivityLog('retrieve', $partnerId, Partner::$modelName, 'Partner', auth()->id(), User::$modelName, 'client_portal');

        return $partnerData;
    }
}
