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
        return $this->employeeModel->getEmployees();
    }

    public function getEmployee($id)
    {
        return $this->employeeModel->getEmployee($id);
    }

    public function createEmployee($data)
    {
        return $this->employeeModel->createEmployee($data);
    }

    public function updateEmployee($id, $data)
    {
        return $this->employeeModel->updateEmployee($id, $data);
    }

    public function deleteEmployee($id)
    {
        return $this->employeeModel->deleteEmployee($id);
    }

    public function getPublicEmployees()
    {
        return $this->employeeModel->getPublicEmployees();
    }

    public function getEmployeeNumber()
    {
        return $this->employeeModel->getEmployeeNumber();
    }
}
