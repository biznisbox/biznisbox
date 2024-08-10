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

    public function liveUpdateCurrencyRate()
    {
        if (!settings('default_currency') == 'EUR') {
            return [
                'message' => __('responses.default_currency_must_be_eur'),
                'status' => false,
            ];
        }
        $currencies = $this->all();
        foreach ($currencies as $currency) {
            $rate = $this->getExchangeRateByECB($currency->code);
            $this->where('id', $currency->id)->update(['exchange_rate' => $rate]);
        }
        $this->where('code', 'EUR')->update(['exchange_rate' => 1]);
        return [
            'message' => __('responses.currency_rate_updated'),
            'status' => true,
        ];
    }

    private function getExchangeRateByECB($code = null)
    {
        $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
        $xml = simplexml_load_file($url);

        $json = json_encode($xml);

        $array = json_decode($json, true);

        foreach ($array['Cube']['Cube']['Cube'] as $key => $value) {
            if ($value['@attributes']['currency'] == $code) {
                return $value['@attributes']['rate'];
            }
        }
        return true;
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
