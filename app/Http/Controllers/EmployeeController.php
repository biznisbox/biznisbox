<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Http\Requests\EmployeeRequest;

/**
 * @group Employees
 *
 * APIs for managing employees
 * @authenticated
 */
class EmployeeController extends Controller
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Get all employees
     *
     * @return array $employees All employees
     */
    public function getEmployees()
    {
        $employees = $this->employeeService->getEmployees();
        if ($employees) {
            return apiResponse($employees, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 404);
    }

    /**
     * Get employee by id
     *
     * @param  string  $id id of the employee
     * @return array $employee employee
     */
    public function getEmployee($id)
    {
        $employee = $this->employeeService->getEmployee($id);
        if ($employee) {
            return apiResponse($employee, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found_with_id'), 404);
    }

    /**
     * Create a new employee
     *
     * @param  object  $request data from the form (name, email, phone, address, department_id)
     * @return array $employee employee
     */
    public function createEmployee(EmployeeRequest $request)
    {
        $data = $request->all();
        $employee = $this->employeeService->createEmployee($data);
        if ($employee) {
            return apiResponse($employee, __('responses.item_created_successfully'));
        }
        return apiResponse(null, __('responses.item_not_created'), 400);
    }

    /**
     * Update an employee
     *
     * @param  object  $request data from the form (name, email, phone, address, department_id)
     * @param  string  $id id of the employee
     * @return array $employee employee
     */
    public function updateEmployee(EmployeeRequest $request, $id)
    {
        $data = $request->all();
        $employee = $this->employeeService->updateEmployee($id, $data);
        if ($employee) {
            return apiResponse($employee, __('responses.item_updated_successfully'));
        }
        return apiResponse(null, __('responses.item_not_updated'), 400);
    }

    /**
     * Delete an employee
     *
     * @param  string  $id id of the employee
     * @return array $employee employee
     */
    public function deleteEmployee($id)
    {
        $employee = $this->employeeService->deleteEmployee($id);
        if ($employee) {
            return apiResponse($employee, __('responses.item_deleted_successfully'));
        }
        return apiResponse(null, __('responses.item_not_deleted'), 400);
    }

    /**
     * Get public employees
     *
     * @return array $employees public employees
     */
    public function getPublicEmployees()
    {
        $employees = $this->employeeService->getPublicEmployees();
        if ($employees) {
            return apiResponse($employees, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 404);
    }

    /**
     * Get employee number
     *
     * @return array $employee employee
     */
    public function getEmployeeNumber()
    {
        $employee = $this->employeeService->getEmployeeNumber();
        if ($employee) {
            return apiResponse($employee, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 404);
    }
}
