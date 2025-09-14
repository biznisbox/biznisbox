<?php

namespace App\Services;

use App\Models\Bill;
use Barryvdh\DomPDF\Facade\Pdf;

class BillService
{
    private $billModel;
    public function __construct(Bill $billModel)
    {
        $this->billModel = new Bill();
    }

    public function getBills()
    {
        return $this->billModel->getBills();
    }

    public function getBill($id)
    {
        return $this->billModel->getBill($id);
    }

    public function createBill($data)
    {
        return $this->billModel->createBill($data);
    }

    public function updateBill($id, $data)
    {
        return $this->billModel->updateBill($id, $data);
    }

    public function deleteBill($id)
    {
        return $this->billModel->deleteBill($id);
    }

    public function getBillNumber()
    {
        return $this->billModel->getBillNumber();
    }

    public function getBillPdf($id, $type = 'stream')
    {
        $bill = $this->billModel->getBill($id);
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
        $pdf = PDF::loadView('pdfs.bill', compact('bill', 'settings'));

        if ($type == 'attach') {
            return $pdf->output();
        }
        if ($type == 'download') {
            createActivityLog('DownloadBillPdf', $bill->id, Bill::$modelName, 'Bill');
            return $pdf->download('Bill ' . $bill->number . '.pdf');
        } else {
            createActivityLog('ViewBillPdf', $bill->id, Bill::$modelName, 'Bill');
            return $pdf->stream('Bill ' . $bill->number . '.pdf');
        }
    }
}
