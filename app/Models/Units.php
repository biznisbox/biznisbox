<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Units extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'units';

    protected $fillable = ['name', 'symbol'];

    public function generateTags(): array
    {
        return ['Units'];
    }

    public function getUnits()
    {
        return $this->all(['id', 'name', 'symbol']);
    }

    public function getUnitById($id)
    {
        return self::find($id);
    }

    public function getUnitByName($name)
    {
        return self::where('name', $name)->first();
    }
}
