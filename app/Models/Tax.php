<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Tax extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Tax';

    protected $fillable = ['name', 'rate', 'active', 'description', 'type'];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['Tax'];
    }

    protected $appends = ['value'];

    protected $hidden = ['created_at', 'updated_at', 'active'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'tax');
    }

    public function getValueAttribute()
    {
        return $this->rate;
    }

    public function getTaxes()
    {
        $taxes = $this->all()->where('active', true);
        createActivityLog('retrieve', null, Tax::$modelName, 'Tax');
        return $taxes;
    }

    public function getTax($id)
    {
        $tax = $this->find($id);
        createActivityLog('retrieve', $id, Tax::$modelName, 'Tax');
        return $tax;
    }

    public function createTax($data)
    {
        $tax = $this->create($data);
        return $tax;
    }

    public function updateTax($data, $id)
    {
        $tax = $this->find($id);
        $tax->update($data);
        return $tax;
    }

    public function deleteTax($id)
    {
        $tax = $this->find($id);
        $tax->delete();
        return $tax;
    }
}
