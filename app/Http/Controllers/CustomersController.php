<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    private $customerModel;
    public function __construct(Customer $customerModel)
    {
        $this->customerModel = $customerModel;
    }

    public function getCustomers()
    {
        $customers = $this->customerModel->getCustomers();

        if ($customers) {
            return api_response($customers, __('response.customer.get_success'));
        }
        return api_response(null, __('response.customer.get_error'), 400);
    }

    public function getCustomer($id)
    {
        $customer = $this->customerModel->getCustomer($id);

        if (!$customer) {
            return api_response(null, __('response.customer.not_found'), 404);
        }
        return api_response($customer, __('response.customer.get_success'));
    }

    public function createCustomer(Request $request)
    {
        $customerData = $request->all();
        $customer = $this->customerModel->createCustomer($customerData);

        if (!$customer) {
            return api_response(null, __('response.customer.create_failed'), 400);
        }
        return api_response($customer, __('response.customer.create_success'), 201);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customerData = $request->all();
        $customer = $this->customerModel->updateCustomer($id, $customerData);

        if (!$customer) {
            return api_response(null, __('response.customer.not_found'), 404);
        }
        return api_response($customer, __('response.customer.update_success'), 200);
    }

    public function deleteCustomer($id)
    {
        $customer = $this->customerModel->deleteCustomer($id);

        if (!$customer) {
            return api_response(null, __('response.customer.not_found'), 404);
        }
        return api_response($customer, __('response.customer.delete_success'), 200);
    }

    public function getCustomerNumber()
    {
        $customerNumber = $this->customerModel->getCustomerNumber();

        if ($customerNumber) {
            return api_response($customerNumber, __('response.customer.get_success'));
        }
        return api_response(null, __('response.customer.get_error'), 400);
    }
}
