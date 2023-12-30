<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'guard_name', 'display_name', 'description'];

    protected $casts = [
        'id' => 'string',
    ];

    public function getDisplayNameAttribute($value)
    {
        return __($this->attributes['display_name']);
    }
}
