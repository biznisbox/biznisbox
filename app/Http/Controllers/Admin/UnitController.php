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
 * @authenticated
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
            return apiResponse($units, __('responses.item_not_found'), 404);
        }
        return apiResponse($units, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get unit by id
     *
     * @param  string  $id id of the unit
     * @return array $unit unit
     */
    public function getUnit($id)
    {
        $unit = $this->unitService->getUnit($id);

        if (!$unit) {
            return apiResponse($unit, __('responses.item_not_found_with_id'), 404);
        }
        return apiResponse($unit, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get unit by name
     *
     * @param  string  $name name of the unit
     * @return array $unit unit
     */
    public function getUnitByName($name)
    {
        $unit = $this->unitService->getUnitByName($name);

        if (!$unit) {
            return apiResponse($unit, __('responses.item_not_found'), 404);
        }
        return apiResponse($unit, __('responses.data_retrieved_successfully'));
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
            return apiResponse($unit, __('responses.item_not_created'), 400);
        }
        return apiResponse($unit, __('responses.item_created_successfully'));
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
            return apiResponse($unit, __('responses.item_not_updated'), 400);
        }
        return apiResponse($unit, __('responses.item_updated_successfully'));
    }

    /**
     * Delete a unit
     *
     * @param  string  $id id of the unit
     * @return array $unit unit
     */
    public function deleteUnit($id)
    {
        if (!$id) {
            return apiResponse(null, __('responses.item_not_found_with_id'), 404);
        }
        $unit = $this->unitService->deleteUnit($id);

        if (!$unit) {
            return apiResponse($unit, __('responses.item_not_deleted'), 400);
        }
        return apiResponse($unit, __('responses.item_deleted_successfully'));
    }
}
