<?php

namespace App\Services;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractService
{
    private $contractModel;

    public function __construct()
    {
        $this->contractModel = new Contract();
    }

    public function getContracts()
    {
        $contracts = $this->contractModel->getContracts();
        return $contracts;
    }

    public function getContract($id)
    {
        $contract = $this->contractModel->getContract($id);
        return $contract;
    }

    public function createContract($data)
    {
        $contract = $this->contractModel->createContract($data);
        return $contract;
    }

    public function updateContract($id, $data)
    {
        $contract = $this->contractModel->updateContract($id, $data);
        return $contract;
    }

    public function deleteContract($id)
    {
        $contract = $this->contractModel->deleteContract($id);
        return $contract;
    }

    public function getContractNumber()
    {
        $contract = $this->contractModel->getContractNumber();
        return $contract;
    }

    public function getContractPdf($id, $type = 'stream')
    {
        $contract = $this->getContract($id);
        $settings = settings([
            'company_name',
            'company_address',
            'company_city',
            'company_zip',
            'company_country',
            'company_phone',
            'company_email',
            'company_vat',
            'company_logo',
            'show_barcode_on_documents',
            'default_currency',
        ]);
        $pdf = PDF::loadView('pdfs.contract', compact('contract', 'settings'));

        if ($type == 'attach') {
            return $pdf->output();
        }
        if ($type == 'download') {
            createActivityLog('downloadContract', $contract->id, 'App\Models\Contract', 'Contract');
            return $pdf->download('Contract ' . $contract->number . '.pdf');
        } else {
            createActivityLog('viewContract', $contract->id, 'App\Models\Contract', 'Contract');
            return $pdf->stream('Contract ' . $contract->number . '.pdf');
        }
    }

    public function shareContract($id, $data)
    {
        $contract = $this->contractModel->shareContract($id, $data);
        return $contract;
    }
}
