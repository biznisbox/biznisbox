<?php

namespace App\Services\Admin;

use App\Models\Department;

class DepartmentService
{
    private $department;
    public function __construct()
    {
        $this->department = new Department();
    }

    public function getDepartments()
    {
        $departments = $this->department->get();
        createActivityLog('retrieve', null, 'App\Models\Department', 'Department');
        return $departments;
    }

    public function getDepartment($id)
    {
        $department = $this->department->find($id);
        if (!$department) {
            return false;
        }
        createActivityLog('retrieve', $id, 'App\Models\Department', 'Department');
        return $department;
    }

    public function createDepartment($data)
    {
        $department = $this->department->create($data);
        return $department;
    }

    public function updateDepartment($id, $data)
    {
        $department = $this->department->find($id);
        if (!$department) {
            return false;
        }
        $department->update($data);
        return $department;
    }

    public function deleteDepartment($id)
    {
        $department = $this->department->find($id);
        if (!$department) {
            return false;
        }
        $department->delete();
        return true;
    }
}
