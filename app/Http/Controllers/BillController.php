<?php

namespace App\Http\Controllers;

use App\Services\BillService;
use App\Http\Requests\BillRequest;
use Illuminate\Http\Request;

/**
 * @group Bills
 *
 * APIs for managing bills
 */
class BillController extends Controller
{
    private $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    /**
     * Get all bills
     *
     * @return array $bills All bills
     */
    public function getBills()
    {
        $bills = $this->billService->getBills();
        if (!$bills) {
            return api_response($bills, __('responses.item_not_found'), 404);
        }
        return api_response($bills, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get bill by id
     *
     * @param  string  $id id of the bill
     * @return array $bill bill
     */
    public function getBill($id)
    {
        $bill = $this->billService->getBill($id);
        if (!$bill) {
            return api_response($bill, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($bill, __('responses.item_retrieved_successfully'), 200);
    }

    /**
     * Create a new bill
     *
     * @param  object  $request data from the form (bill_number, bill_date, due_date, customer_id, items)
     * @return array $bill bill
     */
    public function createBill(BillRequest $request)
    {
        $bill = $this->billService->createBill($request->all());
        if (!$bill) {
            return api_response($bill, __('responses.item_not_created'), 400);
        }
        return api_response($bill, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update a bill
     *
     * @param  object  $request data from the form (bill_number, bill_date, due_date, customer_id, items)
     * @param  string  $id id of the bill
     * @return array $bill bill
     */
    public function updateBill(BillRequest $request, $id)
    {
        $bill = $this->billService->updateBill($id, $request->all());
        if (!$bill) {
            return api_response($bill, __('responses.item_not_updated'), 400);
        }
        return api_response($bill, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete a bill
     *
     * @param  string  $id id of the bill
     * @return array $bill bill
     */
    public function deleteBill($id)
    {
        $bill = $this->billService->deleteBill($id);
        if (!$bill) {
            return api_response($bill, __('responses.item_not_deleted'), 400);
        }
        return api_response($bill, __('responses.item_deleted_successfully'), 200);
    }

    /**
     * Get bill number
     *
     * @return array $bill bill
     */
    public function getBillNumber()
    {
        $bill = $this->billService->getBillNumber();
        if (!$bill) {
            return api_response($bill, __('responses.item_not_found'), 404);
        }
        return api_response($bill, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get bill pdf
     *
     * @param  object  $request data from the form (type)
     * @param  string  $id id of the bill
     * @return array $bill bill
     */
    public function getBillPdf(Request $request, $id)
    {
        if (!$request->hasValidSignatureWhileIgnoring(['lang'])) {
            return api_response(null, __('responses.invalid_signature'), 400);
        }
        $type = $request->input('type', 'stream');
        $pdf = $this->billService->getBillPdf($id, $type);
        return $pdf;
    }
}
