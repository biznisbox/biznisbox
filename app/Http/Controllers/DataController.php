<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataService;

class DataController extends Controller
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function returnData($type)
    {
        switch ($type) {
            case 'units':
                return $this->dataService->getUnits();
                break;
            case 'taxes':
                return $this->dataService->getTaxes();
                break;
            case 'employees':
                return $this->dataService->getPublicEmployees();
                break;
            case 'users':
                return $this->dataService->getPublicUsers();
                break;
            case 'departments':
                return $this->dataService->getDepartments();
                break;
            case 'products':
                return $this->dataService->getProducts();
                break;
            case 'locales':
                return $this->dataService->getAvailableLocales();
                break;
            case 'currencies':
                return $this->dataService->getCurrencies();
                break;
            default:
                return null;
                break;
        }
    }

    public function getData(Request $request)
    {
        $type = $request->input('type');
        $data = $this->returnData($type);
        return api_response($data, __('responses.data_retrieved_successfully'));
    }

    public function getDashboardData(Request $request)
    {
        $dashboardService = new \App\Services\DashboardDataService();
        $type = $request->input('type');
        $data = $dashboardService->returnData($type);
        return api_response($data, __('responses.data_retrieved_successfully'));
    }

    /***********************************
     * Activity log methods
     ***********************************/

    public function getLogs(Request $request)
    {
        $item_id = $request->input('item_id');
        $item_type = $request->input('item_type');
        $data = $this->dataService->getLogs($item_id, $item_type);
        return api_response($data, __('responses.data_retrieved_successfully'));
    }

    /***********************************
     * Category methods
     ***********************************/

    public function getCategories(Request $request)
    {
        $module = $request->input('module');
        $data = $this->dataService->getCategories($module);
        return api_response($data, __('responses.data_retrieved_successfully'));
    }

    public function createCategory(Request $request)
    {
        $data = $request->all();
        $category = $this->dataService->createCategory($data);
        if (!$category) {
            return api_response($category, __('responses.item_not_created'), 400);
        }
        return api_response($category, __('responses.item_created_successfully'));
    }

    public function updateCategory($id, Request $request)
    {
        $data = $request->all();
        $category = $this->dataService->updateCategory($id, $data);
        if (!$category) {
            return api_response($category, __('responses.item_not_updated'), 400);
        }
        return api_response($category, __('responses.item_updated_successfully'));
    }

    public function deleteCategory($id)
    {
        $category = $this->dataService->deleteCategory($id);
        if (!$category) {
            return api_response($category, __('responses.item_not_deleted'), 400);
        }
        return api_response($category, __('responses.item_deleted_successfully'));
    }

    public function getCategory($id)
    {
        $category = $this->dataService->getCategory($id);
        if (!$category) {
            return api_response($category, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($category, __('responses.data_retrieved_successfully'));
    }

    /***********************************
     * Dashboard layout methods
     ***********************************/

    public function getDashboardLayout(Request $request)
    {
        $type = $request->input('type') ?? 'user';
        $layout = $this->dataService->getDashboardLayout($type);
        return api_response($layout, __('responses.data_retrieved_successfully'));
    }

    public function updateDashboardLayout(Request $request)
    {
        $layout = $request->layout;
        $type = $request->type ?? 'user';

        $this->dataService->updateDashboardLayout($layout, $type);

        return api_response(null, __('responses.item_updated_successfully'));
    }

    /***********************************
     * Webhook subscription methods
     ***********************************/
    public function createWebhookSubscription(Request $request)
    {
        $data = $request->all();
        $webhookSubscription = $this->dataService->createWebhookSubscription($data);
        if (!$webhookSubscription) {
            return api_response($webhookSubscription, __('responses.item_not_created'), 400);
        }
        return api_response($webhookSubscription, __('responses.item_created_successfully'));
    }
}
