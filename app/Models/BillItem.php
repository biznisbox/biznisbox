<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class BillItem extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\BillItem';

    protected $table = 'bill_items';
    protected $fillable = [
        'bill_id',
        'product_id',
        'name',
        'description',
        'unit',
        'quantity',
        'tax',
        'tax_type',
        'discount',
        'discount_type',
        'price',
        'total',
    ];

    protected $casts = [
        'quantity' => 'double',
        'price' => 'double',
        'tax' => 'double',
        'discount' => 'double',
        'total' => 'double',
    ];

    protected $dates = ['deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function generateTags(): array
    {
        return ['BillItem'];
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
