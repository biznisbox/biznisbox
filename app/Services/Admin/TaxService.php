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
        $taxes = $this->taxModel->getTaxes();
        return $taxes;
    }

    public function getTax($id)
    {
        $tax = $this->taxModel->getTax($id);
        return $tax;
    }

    public function createTax($data)
    {
        $tax = $this->taxModel->createTax($data);
        return $tax;
    }

    public function updateTax($data, $id)
    {
        $tax = $this->taxModel->updateTax($data, $id);
        return $tax;
    }

    public function deleteTax($id)
    {
        $tax = $this->taxModel->deleteTax($id);
        return $tax;
    }

    public function importTaxRates($countryCode)
    {
        $euVatRates = new EuVatRates();
        $euVatRates = $euVatRates->insertTaxesIntoDatabase($countryCode);
        return $euVatRates;
    }
}
