<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{

    protected $partnerModel;
    public function __construct(Partner $partnerModel)
    {
        $this->partnerModel = $partnerModel;
    }

    public function getPartners(Request $request)
    {
        $type = $request->type ?? null;
        $partners = $this->partnerModel->getPartners($type);
        activity_log(user_data()->data->id, 'get partners', null, 'App\Services\PartnerService', 'getPartners', 'Partner');
        if ($partners) {
            return api_response($partners);
        }
        return api_response(null, __('response.partner.not_found'), 404);
    }

    public function getPartner($id)
    {
        $partner = $this->partnerModel->getPartner($id);
        activity_log(user_data()->data->id, 'get partner', null, 'App\Services\PartnerService', 'getPartner', 'Partner');
        if ($partner) {
            return api_response($partner);
        }
        return api_response(null, __('response.partner.not_found'), 404);
    }

    public function createPartner(Request $request)
    {
        $data = $request->all();
        $partner = $this->partnerModel->createPartner($data);
        if ($partner) {
            return api_response($partner, __('response.partner.created'));
        }
        return api_response(null, __('response.partner.not_created'), 404);
    }

    public function updatePartner(Request $request, $id)
    {
        $data = $request->all();
        $partner = $this->partnerModel->updatePartner($id, $data);
        if ($partner) {
            return api_response($partner, __('response.partner.updated'));
        }
        return api_response(null, __('response.partner.not_updated'), 404);
    }

    public function deletePartner($id)
    {
        $partner = $this->partnerModel->deletePartner($id);
        if ($partner) {
            return api_response($partner, __('response.partner.deleted'));
        }
        return api_response(null, __('response.partner.not_deleted'), 404);
    }

    public function getPartnerNumber(Request $request)
    {
        $number = $this->partnerModel->getPartnerNumber();
        if ($number) {
            return api_response($number);
        }
        return api_response(null, __('response.partner.not_found'), 404);
    }
}
