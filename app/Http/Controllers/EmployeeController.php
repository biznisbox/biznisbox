<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function getEmployees()
    {
        $employees = $this->employeeService->getEmployees();
        if ($employees) {
            return api_response($employees, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found'), 404);
    }

    public function getEmployee($id)
    {
        $employee = $this->employeeService->getEmployee($id);
        if ($employee) {
            return api_response($employee, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found_with_id'), 404);
    }

    public function createEmployee(EmployeeRequest $request)
    {
        $data = $request->all();
        $employee = $this->employeeService->createEmployee($data);
        if ($employee) {
            return api_response($employee, __('responses.item_created_successfully'));
        }
        return api_response(null, __('responses.item_not_created'), 400);
    }

    public function updateEmployee(EmployeeRequest $request, $id)
    {
        $data = $request->all();
        $employee = $this->employeeService->updateEmployee($id, $data);
        if ($employee) {
            return api_response($employee, __('responses.item_updated_successfully'));
        }
        return api_response(null, __('responses.item_not_updated'), 400);
    }

    public function deleteEmployee($id)
    {
        $employee = $this->employeeService->deleteEmployee($id);
        if ($employee) {
            return api_response($employee, __('responses.item_deleted_successfully'));
        }
        return api_response(null, __('responses.item_not_deleted'), 400);
    }

    public function getPublicEmployees()
    {
        $employees = $this->employeeService->getPublicEmployees();
        if ($employees) {
            return api_response($employees, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found'), 404);
    }

    public function getEmployeeNumber()
    {
        $employee = $this->employeeService->getEmployeeNumber();
        if ($employee) {
            return api_response($employee, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found'), 404);
    }
}
