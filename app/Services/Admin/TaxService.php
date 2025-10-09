<?php

namespace App\Services\Admin;

use App\Models\Tax;
use App\Integrations\EuVatRates;

class TaxService
{
    private $taxModel;

    public function __construct()
    {
        $this->taxModel = new Tax();
    }

    public function getTaxes()
    {
        return $this->taxModel->getTaxes();
    }

    public function getTax($id)
    {
        return $this->taxModel->getTax($id);
    }

    public function createTax($data)
    {
        return $this->taxModel->createTax($data);
    }

    public function updateTax($data, $id)
    {
        return $this->taxModel->updateTax($data, $id);
    }

    public function deleteTax($id)
    {
        return $this->taxModel->deleteTax($id);
    }

    public function importTaxRates($countryCode)
    {
        $euVatRates = new EuVatRates();
        $euVatRates = $euVatRates->insertTaxesIntoDatabase($countryCode);
        return $euVatRates;
    }
}
