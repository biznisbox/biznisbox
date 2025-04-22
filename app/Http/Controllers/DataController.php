<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataService;

/**
 * @group Data
 *
 * APIs for managing data
 * @authenticated
 */
class DataController extends Controller
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /***********************************
     * Data methods
     ***********************************/
    /**
     * Get data
     *
     * @param  object  $request data from the form (type)
     * @return array $data data
     */
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

    /**
     * Get data
     *
     * @param  object  $request data from the form (type)
     * @queryParam type string required Type of data to retrieve. Example: units, taxes, employees, users, departments, products, locales, currencies
     * @return array $data data
     */
    public function getData(Request $request)
    {
        $type = $request->input('type');
        $data = $this->returnData($type);
        return api_response($data, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get dashboard data
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * Get activity logs
     *
     * @param Request $request
     * @queryParam item_id string required ID of the item
     * @queryParam item_type string required Type of the item (e.g. Invoice, User)
     * @return void
     */
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

    /**
     * Get categories for a module
     *
     * @param Request $request module
     * @return void
     */
    public function getCategories(Request $request)
    {
        $module = $request->input('module');
        $list = $request->input('list', false);
        $data = $this->dataService->getCategories($module, $list);
        return api_response($data, __('responses.data_retrieved_successfully'));
    }

    /**
     * Create category
     *
     * @param Request $request
     * @return void
     */
    public function createCategory(Request $request)
    {
        $data = $request->all();
        $category = $this->dataService->createCategory($data);
        if (!$category) {
            return api_response($category, __('responses.item_not_created'), 400);
        }
        return api_response($category, __('responses.item_created_successfully'));
    }

    /**
     * Update category
     *
     * @param [type] $id
     * @param Request $request
     * @return void
     */
    public function updateCategory($id, Request $request)
    {
        $data = $request->all();
        $category = $this->dataService->updateCategory($id, $data);
        if (!$category) {
            return api_response($category, __('responses.item_not_updated'), 400);
        }
        return api_response($category, __('responses.item_updated_successfully'));
    }

    /**
     * Delete category
     *
     * @param [type] $id
     * @return void
     */
    public function deleteCategory($id)
    {
        $category = $this->dataService->deleteCategory($id);
        if (!$category) {
            return api_response($category, __('responses.item_not_deleted'), 400);
        }
        return api_response($category, __('responses.item_deleted_successfully'));
    }

    /**
     * Get category by id
     *
     * @param [type] $id
     * @return void
     */
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

    /**
     * Get dashboard layout
     *
     * @param Request $request
     * @return void
     */
    public function getDashboardLayout(Request $request)
    {
        $type = $request->input('type') ?? 'user';
        $layout = $this->dataService->getDashboardLayout($type);
        return api_response($layout, __('responses.data_retrieved_successfully'));
    }

    /**
     * Update dashboard layout
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * Get webhook subscriptions
     *
     * @param  object  $request data from the form (type)
     * @return array $webhookSubscriptions webhook subscriptions
     */
    public function createWebhookSubscription(Request $request)
    {
        $data = $request->all();
        $webhookSubscription = $this->dataService->createWebhookSubscription($data);
        if (!$webhookSubscription) {
            return api_response($webhookSubscription, __('responses.item_not_created'), 400);
        }
        return api_response($webhookSubscription, __('responses.item_created_successfully'));
    }

    /**
     * Delete webhook subscription
     *
     * @param  string  $id id of the webhook subscription
     * @return array $webhookSubscription webhook subscription
     */
    public function deleteWebhookSubscription($id)
    {
        $webhookSubscription = $this->dataService->deleteWebhookSubscription($id);
        if (!$webhookSubscription) {
            return api_response($webhookSubscription, __('responses.item_not_deleted'), 400);
        }
        return api_response($webhookSubscription, __('responses.item_deleted_successfully'));
    }

    /****************************************
     * Personal access token methods
     ****************************************/

    /**
     * Get personal access tokens
     */
    public function getPersonalAccessTokens()
    {
        $personalAccessTokens = $this->dataService->getPersonalAccessTokens();
        return api_response($personalAccessTokens, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get personal access token
     */
    public function getPersonalAccessToken($id)
    {
        $personalAccessToken = $this->dataService->getPersonalAccessToken($id);
        if (!$personalAccessToken) {
            return api_response($personalAccessToken, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($personalAccessToken, __('responses.data_retrieved_successfully'));
    }

    /**
     * Create personal access token
     */
    public function createPersonalAccessToken(Request $request)
    {
        $data = $request->all();
        $token = $this->dataService->createPersonalAccessToken($data);
        if (!$token) {
            return api_response($token, __('responses.item_not_created'), 400);
        }
        return api_response($token, __('responses.item_created_successfully'));
    }

    /**
     * Delete personal access token
     */
    public function deletePersonalAccessToken($id)
    {
        $personalAccessToken = $this->dataService->deletePersonalAccessToken($id);
        if (!$personalAccessToken) {
            return api_response($personalAccessToken, __('responses.item_not_deleted'), 400);
        }
        return api_response($personalAccessToken, __('responses.item_deleted_successfully'));
    }
}
