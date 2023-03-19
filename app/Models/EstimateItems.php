<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class EstimateItems extends Model implements Auditable
{
    use HasFactory, HasUuids, \OwenIt\Auditing\Auditable;

    protected $fillable = ['estimate_id', 'product_id', 'name', 'description', 'unit', 'quantity', 'price', 'tax', 'discount', 'total'];

    protected $casts = [
        'quantity' => 'float',
        'price' => 'float',
        'tax' => 'float',
        'discount' => 'float',
        'total' => 'float',
    ];

    public function generateTags(): array
    {
        return ['EstimateItems'];
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
