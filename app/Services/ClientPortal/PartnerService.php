<?php

namespace App\Services\ClientPortal;

use App\Models\Partner;

class PartnerService
{
    public function getPartner()
    {
        $partnerId = getPartnerIdFromUserId(auth()->id());

        $partnerData = Partner::with(['contacts', 'addresses'])
            ->where('id', $partnerId)
            ->first()
            ?->makeHidden(['notes', 'contacts.notes', 'addresses.notes']); // remove notes

        createActivityLog('retrieve', $partnerId, 'App\Models\Partner', 'Partner', auth()->id(), 'App\Models\User', 'client_portal');

        return $partnerData;
    }
}
