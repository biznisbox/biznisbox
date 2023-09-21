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
        'price' => 'float:2',
        'total' => 'float:2',
    ];
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];
    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function generateTags(): array
    {
        return ['BillItems'];
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
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
