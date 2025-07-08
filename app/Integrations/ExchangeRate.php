<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ExchangeRate
{
    /**
     * Get exchange rate by currency code from European Central Bank.
     *
     * @param string $currencyCode
     * @return float|null
     */
    public function getExchangeRateByECB($code = null)
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
        return null;
    }

    /**
     * Get current exchange rates from exchange-api (https://github.com/fawazahmed0/exchange-api#readme)
     *
     * @param string|null $from Represents the base currency code (e.g., 'USD', 'EUR').
     * @param string|null $to Represents the target currency code (e.g., 'USD', 'EUR').
     * @return string|null Returns an associative value with 'rate' as the key and the exchange rate as the value, or null if the request fails.
     */
    public function getExchangeRateByCurrencyApi($from = null, $to = null)
    {
        $from = Str::lower($from);
        $to = Str::lower($to);
        $url = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/' . $from . '.json';

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data[$from][$to])) {
                return $data[$from][$to];
            }
            return null;
        }
    }
}
