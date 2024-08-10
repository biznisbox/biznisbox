<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class QuoteItem extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'quote_items';

    protected $fillable = [
        'quote_id',
        'product_id',
        'name',
        'description',
        'quantity',
        'price',
        'discount_type',
        'discount',
        'tax',
        'tax_type',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'float',
            'price' => 'float',
            'discount' => 'float',
            'tax' => 'float',
            'total' => 'float',
        ];
    }

    public function generateTags(): array
    {
        return ['QuoteItem'];
    }

    protected $dates = ['deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
