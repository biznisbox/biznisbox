<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    protected $departmentsModel;
    public function __construct(Department $departmentsModel)
    {
        $this->departmentsModel = $departmentsModel;
    }

    public function getDepartments()
    {
        $departments = $this->departmentsModel->getDepartments();
        activity_log(user_data()->data->id, 'get departments', null, 'App\Http\Controllers\Admin\DepartmentController', 'getDepartments');
        return api_response($departments);
    }

    public function getDepartment(Request $request)
    {
        $department_id = $request->id;
        $department = $this->departmentsModel->getDepartment($department_id);
        activity_log(
            user_data()->data->id,
            'get department',
            $department_id,
            'App\Http\Controllers\Admin\DepartmentController',
            'getDepartment'
        );
        if ($department) {
            return api_response($department);
        }
        return api_response(null, __('response.department.not_found'), 404);
    }

    public function createDepartment(Request $request)
    {
        $data = $request->all();
        $department = $this->departmentsModel->createDepartment($data);
        if ($department) {
            return api_response($department, __('response.department.create_success'), 201);
        }
        return api_response(null, __('response.department.create_failed'), 400);
    }

    public function updateDepartment(Request $request)
    {
        $department_id = $request->id;
        $data = $request->all();
        $department = $this->departmentsModel->updateDepartment($department_id, $data);
        if ($department) {
            return api_response($department, __('response.department.update_success'));
        }
        return api_response(null, __('response.department.update_failed'), 400);
    }

    public function deleteDepartment(Request $request)
    {
        $department_id = $request->id;
        $department = $this->departmentsModel->deleteDepartment($department_id);
        if ($department) {
            return api_response($department, __('response.department.delete_success'));
        }
        return api_response(null, __('response.department.delete_failed'), 400);
    }

    public function getDepartmentsWithEmployees()
    {
        $departments = $this->departmentsModel->getDepartmentsWithEmployees();
        activity_log(
            user_data()->data->id,
            'get departments with employees',
            null,
            'App\Http\Controllers\Admin\DepartmentController',
            'getDepartmentsWithEmployees'
        );
        return api_response($departments);
    }
}
