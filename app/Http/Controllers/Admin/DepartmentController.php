<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\DepartmentService;

/**
 * @group Departments
 *
 * APIs for managing departments
 * @authenticated
 */
class DepartmentController extends Controller
{
    private $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Get all departments
     *
     * @return array $departments All departments
     */
    public function getDepartments()
    {
        $departments = $this->departmentService->getDepartments();
        if (!$departments) {
            return apiResponse($departments, __('responses.item_not_found'), 404);
        }
        return apiResponse($departments, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get department by id
     *
     * @param  string  $id id of the department
     * @return array $department department
     */
    public function getDepartment($id)
    {
        $department = $this->departmentService->getDepartment($id);
        if (!$department) {
            return apiResponse($department, __('responses.item_not_found_with_id'), 404);
        }
        return apiResponse($department, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create a new department
     *
     * @param  object  $request data from the form (name)
     * @return array $department department
     */
    public function createDepartment(Request $request)
    {
        $data = $request->all();
        $department = $this->departmentService->createDepartment($data);
        if (!$department) {
            return apiResponse($department, __('responses.item_not_created'), 400);
        }
        return apiResponse($department, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update department
     *
     * @param  object  $request data from the form (name)
     * @param  string  $id id of the department
     * @return array $department department
     */
    public function updateDepartment(Request $request, $id)
    {
        $data = $request->all();
        $department = $this->departmentService->updateDepartment($id, $data);
        if (!$department) {
            return apiResponse($department, __('responses.item_not_found'), 404);
        }
        return apiResponse($department, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete department
     *
     * @param  string  $id id of the department
     * @return array $department department
     */
    public function deleteDepartment($id)
    {
        $department = $this->departmentService->deleteDepartment($id);
        if (!$department) {
            return apiResponse($department, __('responses.item_not_found'), 404);
        }
        return apiResponse($department, __('responses.item_deleted_successfully'), 200);
    }
}
