<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Unit extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'symbol', 'active', 'description'];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['Unit'];
    }

    protected $hidden = ['created_at', 'updated_at', 'active'];
}
