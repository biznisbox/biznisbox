<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PartnerService;
/**
 * @group Partners
 *
 * APIs for managing partners
 */
class PartnerController extends Controller
{
    private $partnerService;
    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    /**
     * Create a new partner
     *
     * @param  object  $request data from the form
     * @return array $partner partner
     */
    public function createPartner(Request $request)
    {
        $partner = $this->partnerService->createPartner($request->all());
        if (!$partner) {
            return api_response(null, __('responses.item_not_created'), 400);
        }
        return api_response($partner, __('responses.item_created_successfully'));
    }

    /**
     * Update partner
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the partner
     * @return array $partner partner
     */
    public function updatePartner(Request $request, string $id)
    {
        $partner = $this->partnerService->updatePartner($id, $request->all());
        if (!$partner) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($partner, __('responses.item_updated_successfully'));
    }

    /**
     * Delete partner
     *
     * @param  string  $id id of the partner
     * @return array $partner partner
     */
    public function deletePartner(string $id)
    {
        $partner = $this->partnerService->deletePartner($id);
        if (!$partner) {
            return api_response(null, __('responses.item_not_deleted'), 400);
        }
        return api_response($partner, __('responses.item_deleted_successfully'));
    }

    /**
     * Get all partners
     *
     * @return array $partners Partners
     */
    public function getPartners()
    {
        $partners = $this->partnerService->getPartners();
        if (!$partners) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($partners, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get partner by id
     *
     * @param  string  $id id of the partner
     * @return array $partner partner
     */
    public function getPartner(string $id)
    {
        $partner = $this->partnerService->getPartner($id);
        if (!$partner) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($partner, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get partner number
     *
     * @return array $partner partner
     */
    public function getPartnerNumber()
    {
        $partner = $this->partnerService->getPartnerNumber();
        if (!$partner) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($partner, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get partners limited data
     *
     * @param  object  $request data from the form (type)
     * @return array $partners Partners
     */
    public function getPartnersLimitedData(Request $request)
    {
        $type = $request->input('type');
        $partners = $this->partnerService->getPartnersLimitedData($type);
        if ($partners == []) {
            return api_response([], __('responses.data_retrieved_successfully'));
        }
        if (!$partners) {
            return api_response(null, __('responses.item_not_found'), 400);
        }
        return api_response($partners, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get partner activities
     *
     * @return array $partnerActivities Partner activities
     */
    public function createPartnerActivity(Request $request)
    {
        $partnerActivity = $this->partnerService->createPartnerActivity($request->all());
        if (!$partnerActivity) {
            return api_response(null, __('responses.item_not_created'), 400);
        }
        return api_response($partnerActivity, __('responses.item_created_successfully'));
    }

    /**
     * Update partner activity
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the partner activity
     * @return array $partnerActivity partner activity
     */
    public function updatePartnerActivity(Request $request, string $id)
    {
        $partnerActivity = $this->partnerService->updatePartnerActivity($id, $request->all());
        if (!$partnerActivity) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($partnerActivity, __('responses.item_updated_successfully'));
    }

    /**
     * Delete partner activity
     *
     * @param  string  $id id of the partner activity
     * @return array $partnerActivity partner activity
     */
    public function deletePartnerActivity(string $id)
    {
        $partnerActivity = $this->partnerService->deletePartnerActivity($id);
        if (!$partnerActivity) {
            return api_response(null, __('responses.item_not_deleted'), 400);
        }
        return api_response($partnerActivity, __('responses.item_deleted_successfully'));
    }
}
