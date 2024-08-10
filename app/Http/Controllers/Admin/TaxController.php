<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\TaxService;

class TaxController extends Controller
{
    private $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function getTaxes()
    {
        $taxes = $this->taxService->getTaxes();
        if (!$taxes) {
            return api_response($taxes, __('responses.item_not_found'), 404);
        }
        return api_response($taxes, __('responses.data_retrieved_successfully'), 200);
    }

    public function getTax($id)
    {
        $tax = $this->taxService->getTax($id);
        if (!$tax) {
            return api_response($tax, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($tax, __('responses.data_retrieved_successfully'), 200);
    }

    public function createTax(Request $request)
    {
        $data = $request->all();
        $tax = $this->taxService->createTax($data);
        if (!$tax) {
            return api_response($tax, __('responses.item_not_created'), 400);
        }
        return api_response($tax, __('responses.item_created_successfully'), 200);
    }

    public function updateTax(Request $request, $id)
    {
        $data = $request->all();
        $tax = $this->taxService->updateTax($data, $id);
        if (!$tax) {
            return api_response($tax, __('responses.item_not_updated'), 400);
        }
        return api_response($tax, __('responses.item_updated_successfully'), 200);
    }

    public function deleteTax($id)
    {
        $tax = $this->taxService->deleteTax($id);
        if (!$tax) {
            return api_response($tax, __('responses.item_not_deleted'), 400);
        }
        return api_response($tax, __('responses.item_deleted_successfully'), 200);
    }
}
