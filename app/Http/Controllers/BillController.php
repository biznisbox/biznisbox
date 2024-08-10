<?php

namespace App\Http\Controllers;

use App\Services\BillService;
use App\Http\Requests\BillRequest;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function getBills()
    {
        $bills = $this->billService->getBills();
        if (!$bills) {
            return api_response($bills, __('responses.item_not_found'), 404);
        }
        return api_response($bills, __('responses.data_retrieved_successfully'), 200);
    }

    public function getBill($id)
    {
        $bill = $this->billService->getBill($id);
        if (!$bill) {
            return api_response($bill, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($bill, __('responses.item_retrieved_successfully'), 200);
    }

    public function createBill(BillRequest $request)
    {
        $bill = $this->billService->createBill($request->all());
        if (!$bill) {
            return api_response($bill, __('responses.item_not_created'), 400);
        }
        return api_response($bill, __('responses.item_created_successfully'), 200);
    }

    public function updateBill(BillRequest $request, $id)
    {
        $bill = $this->billService->updateBill($id, $request->all());
        if (!$bill) {
            return api_response($bill, __('responses.item_not_updated'), 400);
        }
        return api_response($bill, __('responses.item_updated_successfully'), 200);
    }

    public function deleteBill($id)
    {
        $bill = $this->billService->deleteBill($id);
        if (!$bill) {
            return api_response($bill, __('responses.item_not_deleted'), 400);
        }
        return api_response($bill, __('responses.item_deleted_successfully'), 200);
    }

    public function getBillNumber()
    {
        $bill = $this->billService->getBillNumber();
        if (!$bill) {
            return api_response($bill, __('responses.item_not_found'), 404);
        }
        return api_response($bill, __('responses.data_retrieved_successfully'), 200);
    }

    public function getBillPdf(Request $request, $id)
    {
        $type = $request->input('type', 'stream');
        $pdf = $this->billService->getBillPdf($id, $type);
        return $pdf;
    }
}
