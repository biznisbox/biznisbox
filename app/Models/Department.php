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

    public static $modelName = 'App\Models\Department';

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'type',
        'address',
        'city',
        'zip_code',
        'country',
        'phone_number',
        'email',
        'longitude',
        'latitude',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'longitude' => 'float',
        'latitude' => 'float',
    ];

    protected $appends = ['location'];

    public function generateTags(): array
    {
        return ['Department'];
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }

    public function getLocationAttribute()
    {
        return [$this->longitude, $this->latitude];
    }

    public function getDepartmentsWithEmployees()
    {
        $departments = $this->with('employees')->get();
        createActivityLog('retrieve', null, Department::$modelName, 'Department');
        return $departments;
    }

    public static function getPublicDepartments()
    {
        $departments = self::select(['id', 'name', 'description', 'type'])->get();
        createActivityLog('retrievePublic', null, Department::$modelName, 'Department');
        return $departments;
    }
}
