<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'employees';

    protected $fillable = [
        'department_id',
        'user_id',
        'number',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'description',
        'address',
        'city',
        'zip_code',
        'country',
        'position',
        'type',
        'salary',
        'hourly_rate',
        'level',
        'contract_type',
        'contract_start_date',
        'contract_end_date',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
    ];

    protected $dates = ['contract_start_date', 'contract_end_date'];

    public function generateTags(): array
    {
        return ['Employee'];
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function createEmployee($data)
    {
        $employee = $this->create($data);
        incrementLastItemNumber('employee');
        return $employee;
    }

    public function updateEmployee($id, $data)
    {
        $employee = $this->find($id);
        if ($employee) {
            $employee->update($data);
        }
        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->where('id', $id)->delete();
        return $employee;
    }

    public function getEmployee($id)
    {
        $employee = $this->with('department', 'user')->where('id', $id)->first();
        return $employee;
    }

    public function getEmployees()
    {
        $employees = $this->get();
        return $employees;
    }

    public static function getEmployeeNumber()
    {
        $number = generate_next_number(settings('employee_number_format'), 'employee');
        return $number;
    }

    public function getPublicEmployees()
    {
        $employees = $this->select('id', 'first_name', 'last_name', 'email', 'phone_number')->get();
        foreach ($employees as $employee) {
            $employee->label = $employee->first_name . ' ' . $employee->last_name . ' (' . $employee->email . ')';
        }
        return $employees;
    }
}
