<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estimate;
class EstimateController extends Controller
{
    protected $estimateModel;
    public function __construct(Estimate $estimateModel)
    {
        $this->estimateModel = $estimateModel;
    }

    public function getEstimates()
    {
        $estimates = $this->estimateModel->getEstimates();

        if (!$estimates) {
            return api_response(null, __('response.estimate.get_failed'), 500);
        }
        return api_response($estimates, __('response.estimate.get_success'));
    }

    public function getEstimate($id)
    {
        $estimate = $this->estimateModel->getEstimate($id);

        if (!$estimate) {
            return api_response(null, __('response.estimate.not_found'), 500);
        }
        return api_response($estimate, __('response.estimate.get_success'));
    }

    public function createEstimate(Request $request)
    {
        $estimateData = $request->all();
        $estimate = $this->estimateModel->createEstimate($estimateData);

        if (!$estimate) {
            return api_response(null, __('response.estimate.create_failed'), 500);
        }
        return api_response($estimate, __('response.estimate.create_success'), 201);
    }

    public function updateEstimate(Request $request, $id)
    {
        $estimateData = $request->all();
        $estimate = $this->estimateModel->updateEstimate($id, $estimateData);

        if (!$estimate) {
            return api_response(null, __('response.estimate.update_failed'), 500);
        }
        return api_response($estimate, __('response.estimate.update_success'));
    }

    public function deleteEstimate($id)
    {
        $estimate = $this->estimateModel->deleteEstimate($id);

        if (!$estimate) {
            return api_response(null, __('response.estimate.delete_failed'), 500);
        }
        return api_response($estimate, __('response.estimate.delete_success'));
    }

    public function getEstimateNumber()
    {
        $estimate_number = $this->estimateModel->getEstimateNumber();

        if (!$estimate_number) {
            return api_response(null, __('response.estimate.get_error'), 500);
        }
        return api_response($estimate_number, __('response.estimate.get_success'));
    }

    public function convertEstimateToInvoice($id)
    {
        $estimate_to_invoice = $this->estimateModel->convertEstimateToInvoice($id);

        if (!$estimate_to_invoice) {
            return api_response(null, __('response.estimate.convert_failed'), 500);
        }
        return api_response($estimate_to_invoice, __('response.estimate.convert_success'));
    }

    public function getEstimatePdf(Request $request)
    {
        $estimate_pdf = $this->estimateModel->getEstimatePdf($request->id, $request->type);

        if (!$estimate_pdf) {
            return api_response(null, __('response.estimate.pdf_failed'), 500);
        }
        return $estimate_pdf;
    }

    public function shareEstimate($id)
    {
        $estimate_share = $this->estimateModel->shareEstimate($id);

        if (!$estimate_share) {
            return api_response(null, __('response.estimate.share_failed'), 500);
        }
        return api_response($estimate_share, __('response.estimate.share_success'));
    }

    public function sendEstimate($id)
    {
        $estimate_send = $this->estimateModel->sendEstimate($id);

        if (!$estimate_send) {
            return api_response(null, __('response.estimate.send_failed'), 500);
        }
        return api_response($estimate_send, __('response.estimate.send_success'));
    }
}
