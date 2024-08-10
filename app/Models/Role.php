<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends SpatieRole implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id', 'name', 'guard_name', 'system', 'display_name', 'description'];

    protected $hidden = ['pivot'];

    protected $casts = [
        'system' => 'boolean',
    ];
}
