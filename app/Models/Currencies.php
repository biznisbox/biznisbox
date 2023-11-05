<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Currencies extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'currencies';
    protected $fillable = ['name', 'code', 'symbol', 'active', 'rate'];

    protected $casts = [
        'active' => 'boolean',
        'rate' => 'float',
    ];

    public function generateTags(): array
    {
        return ['Currencies'];
    }

    public function getCurrencies()
    {
        $currencies = $this->all(['id', 'name', 'code', 'symbol', 'rate']);
        activity_log(user_data()->data->id, 'get currencies', null, 'App\Models\Currencies', 'getCurrencies');
        return $currencies;
    }

    public function getCurrency($id = null)
    {
        $currency = self::find($id)->get(['id', 'name', 'code', 'symbol', 'rate']);
        activity_log(user_data()->data->id, 'get currency', $id, 'App\Models\Currencies', 'getCurrency');
        return $currency;
    }

    public function getCurrencyByCode($code = null)
    {
        $currency = self::where('code', $code)->get(['id', 'name', 'code', 'symbol', 'rate']);
        activity_log(user_data()->data->id, 'get currency by code', $code, 'App\Models\Currencies', 'getCurrencyByCode');
        return $currency;
    }

    public function liveUpdateCurrencyRate()
    {
        if (!settings('default_currency') == 'EUR') {
            return false;
        }
        $currencies = $this->all(['id', 'code']);
        foreach ($currencies as $currency) {
            $rate = $this->getCurrencyRate($currency->code);
            $this->where('id', $currency->id)->update(['rate' => $rate]);
        }
        $this->where('code', 'EUR')->update(['rate' => 1]);
        return true;
    }

    public function getCurrencyRate($code = null)
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
        return false;
    }
}
