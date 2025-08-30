<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as SpatiePermission;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends SpatiePermission implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Permission';

    protected $fillable = ['id', 'name', 'guard_name', 'display_name', 'description'];

    public function getDisplayNameAttribute($value)
    {
        return __($this->attributes['display_name']);
    }
}
