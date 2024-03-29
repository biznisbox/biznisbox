<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class InvoiceItems extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['invoice_id', 'product_id', 'name', 'description', 'unit', 'quantity', 'price', 'tax', 'discount', 'total'];

    protected $casts = [
        'quantity' => 'double',
        'price' => 'double',
        'tax' => 'double',
        'discount' => 'double',
        'total' => 'double',
    ];

    public function generateTags(): array
    {
        return ['InvoiceItems'];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
