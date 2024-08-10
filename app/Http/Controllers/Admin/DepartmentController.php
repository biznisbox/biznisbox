<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\DepartmentService;

class DepartmentController extends Controller
{
    private $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function getDepartments()
    {
        $departments = $this->departmentService->getDepartments();
        if (!$departments) {
            return api_response($departments, __('responses.item_not_found'), 404);
        }
        return api_response($departments, __('responses.data_retrieved_successfully'), 200);
    }

    public function getDepartment($id)
    {
        $department = $this->departmentService->getDepartment($id);
        if (!$department) {
            return api_response($department, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($department, __('responses.data_retrieved_successfully'), 200);
    }

    public function createDepartment(Request $request)
    {
        $data = $request->all();
        $department = $this->departmentService->createDepartment($data);
        if (!$department) {
            return api_response($department, __('messages.item_not_created'), 400);
        }
        return api_response($department, __('messages.item_created_successfully'), 200);
    }

    public function updateDepartment(Request $request, $id)
    {
        $data = $request->all();
        $department = $this->departmentService->updateDepartment($id, $data);
        if (!$department) {
            return api_response($department, __('responses.item_not_found'), 404);
        }
        return api_response($department, __('responses.item_updated_successfully'), 200);
    }

    public function deleteDepartment($id)
    {
        $department = $this->departmentService->deleteDepartment($id);
        if (!$department) {
            return api_response($department, __('responses.item_not_found'), 404);
        }
        return api_response($department, __('responses.item_deleted_successfully'), 200);
    }
}
