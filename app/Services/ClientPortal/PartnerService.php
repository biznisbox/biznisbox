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
            ->first();

        if ($partnerData) {
            $partnerData->notes = null;

            foreach ($partnerData->contacts as $contact) {
                $contact->notes = null;
            }

            foreach ($partnerData->addresses as $address) {
                $address->notes = null;
            }
        }

        return $partnerData;
    }
}
