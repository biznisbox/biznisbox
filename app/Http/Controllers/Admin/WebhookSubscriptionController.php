<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\WebhookSubscriptionService;

class WebhookSubscriptionController extends Controller
{
    private $webhookSubscriptionService;
    public function __construct()
    {
        $this->webhookSubscriptionService = new WebhookSubscriptionService();
    }

    public function getWebhookSubscriptions()
    {
        $webhookSubscriptions = $this->webhookSubscriptionService->getWebhookSubscriptions();
        return api_response($webhookSubscriptions, __('responses.data_retrieved_successfully'));
    }

    public function getWebhookSubscription($id)
    {
        $webhookSubscription = $this->webhookSubscriptionService->getWebhookSubscription($id);
        if (!$webhookSubscription) {
            return api_response(null, __('responses.data_not_found'), 404);
        }
        return api_response($webhookSubscription, __('responses.data_retrieved_successfully'));
    }

    public function createWebhookSubscription(Request $request)
    {
        $data = $request->all();
        $webhookSubscription = $this->webhookSubscriptionService->createWebhookSubscription($data);
        return api_response($webhookSubscription, __('responses.data_created_successfully'), 201);
    }

    public function updateWebhookSubscription(Request $request, $id)
    {
        $data = $request->all();
        $webhookSubscription = $this->webhookSubscriptionService->updateWebhookSubscription($id, $data);
        if (!$webhookSubscription) {
            return api_response(null, __('responses.data_not_found'), 404);
        }
        return api_response($webhookSubscription, __('responses.data_updated_successfully'));
    }

    public function deleteWebhookSubscription($id)
    {
        $webhookSubscription = $this->webhookSubscriptionService->deleteWebhookSubscription($id);
        if (!$webhookSubscription) {
            return api_response(null, __('responses.data_not_found'), 404);
        }
        return api_response($webhookSubscription, __('responses.data_deleted_successfully'));
    }
}
