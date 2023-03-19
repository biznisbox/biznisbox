<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'guard_name', 'display_name', 'description'];

    protected $casts = [
        'id' => 'string',
    ];
}
