<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Employee extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

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
        'status',
        'type',
        'salary',
        'hourly_rate',
        'level',
        'contract_type',
        'contract_start_date',
        'contract_end_date',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected function casts(): array
    {
        return [
            'contract_start_date' => 'date',
            'contract_end_date' => 'date',
        ];
    }

    public function generateTags(): array
    {
        return ['Employee'];
    }

    protected $appends = ['full_name'];

    protected $dates = ['contract_start_date', 'contract_end_date', 'deleted_at', 'updated_at', 'created_at'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function createEmployee($data)
    {
        $data['number'] = self::getEmployeeNumber();
        $employee = $this->create($data);
        incrementLastItemNumber('employee', settings('employee_number_format'));
        sendWebhookForEvent('employee:created', $employee->toArray());
        return $employee;
    }

    public function updateEmployee($id, $data)
    {
        $employee = $this->find($id);
        if ($employee) {
            $employee->update($data);
        }
        sendWebhookForEvent('employee:updated', $employee->toArray());
        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->where('id', $id)->delete();
        sendWebhookForEvent('employee:deleted', ['id' => $id]);
        return $employee;
    }

    public function getEmployee($id)
    {
        $employee = $this->with('user')->where('id', $id)->first();
        createActivityLog('retrieve', $id, 'App\Models\Employee', 'Employee');
        return $employee;
    }

    public function getEmployees()
    {
        $employees = $this->get();
        createActivityLog('retrieve', null, 'App\Models\Employee', 'Employee');
        return $employees;
    }

    public static function getEmployeeNumber()
    {
        $number = generateNextNumber(settings('employee_number_format'), 'employee');
        return $number;
    }

    public function getPublicEmployees()
    {
        $employees = $this->select('id', 'first_name', 'last_name', 'email', 'phone_number')->get();
        foreach ($employees as $employee) {
            $employee->label = $employee->first_name . ' ' . $employee->last_name . ' (' . $employee->email . ')';
        }
        createActivityLog('retrievePublic', null, 'App\Models\Employee', 'Employee');
        return $employees;
    }
}
