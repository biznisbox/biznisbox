<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;
use App\Services\Admin\UnitService;
use Illuminate\Http\Request;

/**
 * @group Units
 *
 * APIs for managing units
 */
class UnitController extends Controller
{
    private $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    /**
     * Get all units
     *
     * @return array $units All units
     */
    public function getUnits()
    {
        $units = $this->unitService->getUnits();

        if (!$units) {
            return api_response($units, __('responses.item_not_found'), 404);
        }
        return api_response($units, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get unit by id
     *
     * @param  string  $id id of the unit
     * @return array $unit unit
     */
    public function getUnit(Request $request, $id)
    {
        $unit = $this->unitService->getUnit($id);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($unit, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get unit by name
     *
     * @param  string  $name name of the unit
     * @return array $unit unit
     */
    public function getUnitByName(Request $request, $name)
    {
        $unit = $this->unitService->getUnitByName($name);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_found'), 404);
        }
        return api_response($unit, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create a new unit
     *
     * @param  object  $request data from the form (name)
     * @return array $unit unit
     */
    public function createUnit(UnitRequest $request)
    {
        $data = $request->all();
        $unit = $this->unitService->createUnit($data);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_created'), 400);
        }
        return api_response($unit, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update unit
     *
     * @param  object $request data from the form (name)
     * @param  string  $id id of the unit
     * @return array $unit unit
     */
    public function updateUnit(Request $request, $id)
    {
        $data = $request->all();
        $unit = $this->unitService->updateUnit($id, $data);

        if (!$unit) {
            return api_response($unit, __('responses.item_not_updated'), 400);
        }
        return api_response($unit, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete a unit
     *
     * @param  string  $id id of the unit
     * @return array $unit unit
     */
    public function deleteUnit(Request $request, $id)
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
