<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\PartnerAddress;
use App\Models\PartnerContact;

class PartnerService
{
    private $partnerModel;
    public function __construct()
    {
        $this->partnerModel = new Partner();
    }

    public function getPartners($type = null)
    {
        $partners = $this->partnerModel->getPartners($type);
        return $partners;
    }

    public function getPartner($id)
    {
        $partner = $this->partnerModel->getPartner($id);
        return $partner;
    }

    public function createPartner($data)
    {
        $partner = $this->partnerModel->createPartner($data);
        return $partner;
    }

    public function updatePartner($id, $data)
    {
        $partner = $this->partnerModel->updatePartner($id, $data);
        return $partner;
    }

    public function deletePartner(string $id)
    {
        $partner = $this->partnerModel->deletePartner($id);
        return $partner;
    }

    public function getPartnerNumber()
    {
        $partner = $this->partnerModel->getPartnerNumber();
        return $partner;
    }

    public function getPartnersLimitedData($type = null)
    {
        $partners = $this->partnerModel->getPartnersLimitedData($type);
        return $partners;
    }
}
