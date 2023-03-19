<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Taxes extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'taxes';

    protected $fillable = ['name', 'type', 'description', 'value', 'is_active'];

    public function generateTags(): array
    {
        return ['Taxes'];
    }

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'float',
    ];

    public function getTaxes()
    {
        return $this->all(['id', 'name', 'type', 'description', 'value', 'is_active'])->where('is_active', true);
    }

    public function getTaxById($id)
    {
        return self::find($id);
    }

    public function getTaxByName($name)
    {
        return self::where('name', $name)->first();
    }

    public function getTaxByType($type)
    {
        return self::where('type', $type)->first();
    }
}
