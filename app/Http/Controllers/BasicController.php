<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataService;
use App\Services\DashboardService;

class BasicController extends Controller
{
    private $dataService;
    public function __construct()
    {
        $this->dataService = new DataService();
    }

    public function getData(Request $request)
    {
        $requiredData = $request->input('type');
        $data = $this->dataService->returnData($requiredData);
        return api_response($data, __('response.data.success'));
    }

    public function getCategories(Request $request)
    {
        $category_module = $request->input('module');
        $categories = $this->dataService->getCategories($category_module);
        return api_response($categories, __('response.category.success'));
    }

    public function createCategory(Request $request)
    {
        $categoryData = $request->all();
        $category = $this->dataService->createCategory($categoryData);
        if ($category) {
            return api_response($category, __('response.category.create'));
        }
        return api_response($category, __('response.category.error'));
    }

    public function updateCategory(Request $request, $id)
    {
        $categoryData = $request->all();
        $category = $this->dataService->updateCategory($id, $categoryData);
        if ($category) {
            return api_response($category, __('response.category.update'));
        }
        return api_response($category, __('response.category.error'));
    }

    public function deleteCategory($id)
    {
        $category = $this->dataService->deleteCategory($id);
        if ($category) {
            return api_response($category, __('response.category.delete'));
        }
        return api_response($category, __('response.category.error'));
    }

    public function getDashboardData()
    {
        $dashboardService = new DashboardService();
        $data = $dashboardService->getDashboardData();
        return api_response($data);
    }
}
