<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePayment extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'number',
        'payment_method',
        'payment_id',
        'type',
        'amount',
        'currency',
        'description',
        'status',
        'payment_response',
        'payment_ref',
        'payment_document_type',
        'payment_document_id',
        'key',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_response' => 'array',
            'amount' => 'double',
        ];
    }

    public function payment_document()
    {
        return $this->morphTo();
    }

    /**
     * Get payment number
     * @return string payment number
     */
    public static function getPaymentNumber()
    {
        $number = generateNextNumber(settings('payment_number_format'), 'payment');
        return $number;
    }
}
