<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorsController extends Controller
{
    protected $vendorModel;
    public function __construct(Vendor $vendorModel)
    {
        $this->vendorModel = $vendorModel;
    }

    public function getVendors()
    {
        $vendors = $this->vendorModel->getVendors();

        if ($vendors) {
            return api_response($vendors, __('response.vendors.get_success'));
        }
        return api_response(null, __('response.vendors.get_failed'), 400);
    }

    public function getVendor($id)
    {
        $vendor = $this->vendorModel->getVendor($id);

        if ($vendor) {
            return api_response($vendor, __('response.vendor.get_success'));
        }
        return api_response(null, __('response.vendor.not_found'), 404);
    }

    public function createVendor(Request $request)
    {
        $data = $request->all();
        $vendor = $this->vendorModel->createVendor($data);

        if ($vendor) {
            return api_response($vendor, __('response.vendor.create_success'), 201);
        }
        return api_response(null, __('response.vendor.create_failed'), 400);
    }

    public function updateVendor(Request $request, $id)
    {
        $data = $request->all();
        $vendor = $this->vendorModel->updateVendor($id, $data);

        if ($vendor) {
            return api_response($vendor, __('response.vendor.update_success'));
        }
        return api_response(null, __('response.vendor.update_failed'), 400);
    }

    public function deleteVendor($id)
    {
        $vendor = $this->vendorModel->deleteVendor($id);

        if ($vendor) {
            return api_response(null, __('response.vendor.delete_success'));
        }
        return api_response(null, __('response.vendor.delete_failed'), 400);
    }
}
