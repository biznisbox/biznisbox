<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;
use App\Models\Tax;

class EuVatRates
{
    public function getEuRates()
    {
        $url = 'https://raw.githubusercontent.com/ibericode/vat-rates/master/vat-rates.json';
        $response = Http::get($url);

        if ($response->successful()) {
            $items = $response->json();

            $euRates = [];
            foreach ($items['items'] as $country => $rates) {
                $euRates[$country] = $rates;
            }
            return $euRates;
        }
        return null;
    }

    public function getCountryRate($countryCode)
    {
        $rates = $this->getEuRates();
        if ($rates && isset($rates[$countryCode])) {
            return $rates[$countryCode];
        }
        return null;
    }

    public function getCurrentValidTaxRate($countryCode)
    {
        $countryRates = $this->getCountryRate($countryCode);
        if ($countryRates) {
            foreach ($countryRates as $rate) {
                if ($rate['effective_from'] <= now()->toDateString()) {
                    return $rate['rates'];
                }
            }
        }
        return null;
    }

    public function rateJsonNameToHumanName($jsonName)
    {
        $nameMap = [
            'reduced' => __('responses.tax_rates.reduced'),
            'reduced1' => __('responses.tax_rates.reduced1'),
            'reduced2' => __('responses.tax_rates.reduced2'),
            'reduced3' => __('responses.tax_rates.reduced3'),
            'standard' => __('responses.tax_rates.standard'),
            'super_reduced' => __('responses.tax_rates.super_reduced'),
            'zero' => __('responses.tax_rates.zero'),
        ];
        return $nameMap[$jsonName] ?? $jsonName;
    }

    public function insertTaxesIntoDatabase($countryCode)
    {
        $taxRates = $this->getCurrentValidTaxRate($countryCode);

        if ($taxRates) {
            foreach ($taxRates as $rateName => $rateValue) {
                $humanName = $this->rateJsonNameToHumanName($rateName);
                $existingTax = Tax::where('rate', $rateValue)->first();
                if (!$existingTax) {
                    Tax::create([
                        'name' => $humanName,
                        'rate' => $rateValue,
                        'active' => true,
                        'description' => 'Imported VAT rate for ' . $countryCode,
                        'type' => 'percent',
                    ]);
                }
            }
        }
        return true;
    }
}
