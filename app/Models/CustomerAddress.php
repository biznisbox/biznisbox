<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerAddress extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'customer_addresses';

    protected $fillable = ['customer_id', 'address', 'city', 'zip_code', 'country', 'notes', 'type'];

    public function generateTags(): array
    {
        return ['CustomerAddress'];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
