<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
class Currency extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Currency';

    protected $table = 'currencies';

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'status',
        'decimal_separator',
        'thousand_separator',
        'number_of_decimal',
        'placement',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:2',
        'number_of_decimal' => 'integer',
    ];

    public function getExchangeRateAttribute($value)
    {
        return number_format($value, 2);
    }

    public function generateTags(): array
    {
        return ['Currencies'];
    }

    public function getCurrencyRate($from, $to)
    {
        $currency = $this->where('code', $from)->first();
        if (!$currency) {
            return false;
        }
        if ($from == $to) {
            return 1;
        }
        return $currency->exchange_rate;
    }

    public function convertCurrency($amount, $from, $to)
    {
        $rate = $this->getCurrencyRate($from, $to);
        return $amount * $rate;
    }

    public function formatCurrency($amount, $currency = null)
    {
        $currency = $currency ? $currency : settings('default_currency');
        $currency = $this->where('code', $currency)->first();
        $amount = number_format($amount, $currency->number_of_decimal, $currency->decimal_separator, $currency->thousand_separator);
        return $currency->placement == 'after' ? $amount . $currency->symbol : $currency->symbol . $amount;
    }
}
