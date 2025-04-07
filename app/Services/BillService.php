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
        $bills = $this->billModel->getBills();
        return $bills;
    }

    public function getBill($id)
    {
        $bill = $this->billModel->getBill($id);
        return $bill;
    }

    public function createBill($data)
    {
        $bill = $this->billModel->createBill($data);
        return $bill;
    }

    public function updateBill($id, $data)
    {
        $bill = $this->billModel->updateBill($id, $data);
        return $bill;
    }

    public function deleteBill($id)
    {
        $bill = $this->billModel->deleteBill($id);
        return $bill;
    }

    public function getBillNumber()
    {
        $billNumber = $this->billModel->getBillNumber();
        return $billNumber;
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
            createActivityLog('DownloadBillPdf', $bill->id, 'App\Models\Bill', 'Bill');
            return $pdf->download('Bill ' . $bill->number . '.pdf');
        } else {
            createActivityLog('ViewBillPdf', $bill->id, 'App\Models\Bill', 'Bill');
            return $pdf->stream('Bill ' . $bill->number . '.pdf');
        }
    }
}
