<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    private $employeeModel;
    public function __construct()
    {
        $this->employeeModel = new Employee();
    }

    public function getEmployees()
    {
        $employees = $this->employeeModel->getEmployees();
        return $employees;
    }

    public function getEmployee($id)
    {
        $employee = $this->employeeModel->getEmployee($id);
        return $employee;
    }

    public function createEmployee($data)
    {
        $employee = $this->employeeModel->createEmployee($data);
        return $employee;
    }

    public function updateEmployee($id, $data)
    {
        $employee = $this->employeeModel->updateEmployee($id, $data);
        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->employeeModel->deleteEmployee($id);
        return $employee;
    }

    public function getPublicEmployees()
    {
        $employees = $this->employeeModel->getPublicEmployees();
        return $employees;
    }

    public function getEmployeeNumber()
    {
        $employee = $this->employeeModel->getEmployeeNumber();
        return $employee;
    }
}
