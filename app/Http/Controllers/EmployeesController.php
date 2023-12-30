<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeesController extends Controller
{
    protected $employeeModel;

    public function __construct(Employee $employeeModel)
    {
        $this->employeeModel = $employeeModel;
    }

    public function getEmployees()
    {
        $employees = $this->employeeModel->getEmployees();
        activity_log(user_data()->data->id, 'get employees', null, 'App\Controllers\EmployeesController', 'getEmployees', 'Employee');
        if ($employees) {
            return api_response($employees, __('response.employee.get_success'));
        }
        return api_response(null, __('response.employee.not_found'), 404);
    }

    public function getEmployee(Request $request, $id)
    {
        $employee = $this->employeeModel->getEmployee($id);
        activity_log(user_data()->data->id, 'get employee', null, 'App\Controllers\EmployeesController', 'getEmployee', 'Employee');
        if ($employee) {
            return api_response($employee, __('response.employee.get_success'));
        }
        return api_response(null, __('response.employee.not_found'), 404);
    }

    public function createEmployee(Request $request)
    {
        $data = $request->all();
        $employee = $this->employeeModel->createEmployee($data);
        if ($employee) {
            return api_response($employee, __('response.employee.create_success'));
        }
        return api_response(null, __('response.employee.create_failed'), 404);
    }

    public function updateEmployee(Request $request, $id)
    {
        $data = $request->all();
        $employee = $this->employeeModel->updateEmployee($id, $data);
        if ($employee) {
            return api_response($employee, __('response.employee.update_success'));
        }
        return api_response(null, __('response.employee.update_failed'), 404);
    }

    public function deleteEmployee($id)
    {
        $employee = $this->employeeModel->deleteEmployee($id);
        if ($employee) {
            return api_response($employee, __('response.employee.delete_success'));
        }
        return api_response(null, __('response.employee.delete_failed'), 404);
    }

    public function getEmployeeNumber(Request $request)
    {
        $employeeNumber = $this->employeeModel->getEmployeeNumber();
        activity_log(
            user_data()->data->id,
            'get employee number',
            null,
            'App\Controllers\EmployeesController',
            'getEmployeeNumber',
            'Employee',
        );
        if ($employeeNumber) {
            return api_response($employeeNumber, __('response.employee.get_success'));
        }
        return api_response(null, __('response.employee.not_found'), 404);
    }
}
