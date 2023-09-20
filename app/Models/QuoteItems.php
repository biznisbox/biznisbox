<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class QuoteItems extends Model implements Auditable
{
    use HasFactory, HasUuids, \OwenIt\Auditing\Auditable;

    protected $table = 'quote_items';
    protected $fillable = ['quote_id', 'product_id', 'name', 'description', 'unit', 'quantity', 'price', 'tax', 'discount', 'total'];

    protected $casts = [
        'quantity' => 'float',
        'price' => 'float',
        'tax' => 'float',
        'discount' => 'float',
        'total' => 'float',
    ];

    protected $dates = ['deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function generateTags(): array
    {
        return ['QuoteItems'];
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
