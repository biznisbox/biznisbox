<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class BillItems extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'bill_items';

    protected $fillable = ['bill_id', 'product_id', 'name', 'description', 'unit', 'quantity', 'price', 'total'];

    protected $casts = [
        'quantity' => 'float',
        'price' => 'float',
        'total' => 'float',
    ];

    public function generateTags(): array
    {
        return ['BillItems'];
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubTotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}
