<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OnlinePayment extends Model
{
    use HasFactory, HasUuids;

    public $table = 'online_payment';

    protected $fillable = ['payment_method', 'payment_id', 'payment_status', 'payment_response', 'key'];

    public function getPaymentResponseAttribute($value)
    {
        return json_decode($value);
    }

    public function setPaymentResponseAttribute($value)
    {
        $this->attributes['payment_response'] = json_encode($value);
    }
}
