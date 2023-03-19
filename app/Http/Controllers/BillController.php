<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

class BillController extends Controller
{
    protected $billModel;
    public function __construct(Bill $billModel)
    {
        $this->billModel = $billModel;
    }

    public function getBills()
    {
        $bills = $this->billModel->getBills();
        return api_response($bills, __('response.bill.get_success'), 200);
    }

    public function getBill($id)
    {
        $bills = $this->billModel->getBill($id);
        if ($bills) {
            return api_response($bills, __('response.bill.get_success'), 200);
        }
        return api_response(null, __('response.bill.get_error'), 500);
    }

    public function createBill(Request $request)
    {
        $bill = $this->billModel->createBill($request->all());

        if ($bill) {
            return api_response($bill, __('response.bill.create_success'));
        }
        return api_response(null, __('response.bill.create_error'), 500);
    }

    public function updateBill(Request $request, $id)
    {
        $bill = $this->billModel->updateBill($id, $request->all());

        if ($bill) {
            return api_response($bill, __('response.bill.update_success'));
        }
        return api_response(null, __('response.bill.update_error'), 500);
    }

    public function deleteBill($id)
    {
        $bill = $this->billModel->deleteBill($id);

        if ($bill) {
            return api_response(null, __('response.bill.delete_success'));
        }
        return api_response(null, __('response.bill.delete_error'), 500);
    }

    public function getBillNumber()
    {
        $bill_number = $this->billModel->getBillNumber();

        return api_response($bill_number, __('response.bill.get_success'), 200);
    }
}
