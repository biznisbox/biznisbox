<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Department extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'departments';
    protected $fillable = ['name', 'description', 'address', 'city', 'zip_code', 'country', 'phone_number', 'email'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['Department'];
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }

    public function createDepartment($data)
    {
        $department = $this->create($data);
        return $department;
    }

    public function updateDepartment($id, $data)
    {
        $department = $this->where('id', $id)->update($data);
        return $department;
    }

    public function deleteDepartment($id)
    {
        $department = $this->where('id', $id)->delete();
        return $department;
    }

    public function getDepartment($id)
    {
        $department = $this->where('id', $id)->first();
        return $department;
    }

    public function getDepartments()
    {
        $departments = $this->all();
        return $departments;
    }

    public function getDepartmentsWithEmployees()
    {
        $departments = $this->with('employees')->get();
        return $departments;
    }
}
