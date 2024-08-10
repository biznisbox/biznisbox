<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;
use App\Services\Admin\UnitService;

class UnitController extends Controller
{
    private $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function getUnits()
    {
        $units = $this->unitService->getUnits();

        if (!$units) {
            return api_response($units, __('responses.item_not_found'), 404);
        }
        return api_response($units, __('responses.data_retrieved_successfully'));
    }

    public function getUnit($id)
    {
        $unit = $this->unitService->getUnit($id);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($unit, __('responses.data_retrieved_successfully'), 200);
    }

    public function getUnitByName($name)
    {
        $unit = $this->unitService->getUnitByName($name);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_found'), 404);
        }
        return api_response($unit, __('responses.data_retrieved_successfully'), 200);
    }

    public function createUnit(UnitRequest $request)
    {
        $data = $request->all();
        $unit = $this->unitService->createUnit($data);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_created'), 400);
        }
        return api_response($unit, __('responses.item_created_successfully'), 200);
    }

    public function updateUnit(UnitRequest $request, $id)
    {
        $data = $request->all();
        $unit = $this->unitService->updateUnit($id, $data);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_updated'), 400);
        }
        return api_response($unit, __('responses.item_updated_successfully'), 200);
    }

    public function deleteUnit($id)
    {
        if (!$id) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        $unit = $this->unitService->deleteUnit($id);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_deleted'), 400);
        }
        return api_response($unit, __('responses.item_deleted_successfully'), 200);
    }
}
