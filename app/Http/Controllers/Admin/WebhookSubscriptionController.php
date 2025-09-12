<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\WebhookSubscriptionService;

/**
 * @group Webhook Subscriptions
 *
 * APIs for managing webhook subscriptions
 * @authenticated
 */
class WebhookSubscriptionController extends Controller
{
    private $webhookSubscriptionService;
    public function __construct()
    {
        $this->webhookSubscriptionService = new WebhookSubscriptionService();
    }

    /**
     * Get all webhook subscriptions
     *
     * @return array $webhookSubscriptions All webhook subscriptions
     */
    public function getWebhookSubscriptions()
    {
        $webhookSubscriptions = $this->webhookSubscriptionService->getWebhookSubscriptions();
        return apiResponse($webhookSubscriptions, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get webhook subscription by id
     *
     * @param  string  $id id of the webhook subscription
     * @return array $webhookSubscription webhook subscription
     */
    public function getWebhookSubscription($id)
    {
        $webhookSubscription = $this->webhookSubscriptionService->getWebhookSubscription($id);
        if (!$webhookSubscription) {
            return apiResponse(null, __('responses.data_not_found'), 404);
        }
        return apiResponse($webhookSubscription, __('responses.data_retrieved_successfully'));
    }

    /**
     * Create a new webhook subscription
     *
     * @param  object  $request data from the form (name, url, event)
     * @return array $webhookSubscription webhook subscription
     */
    public function createWebhookSubscription(Request $request)
    {
        $data = $request->all();
        $webhookSubscription = $this->webhookSubscriptionService->createWebhookSubscription($data);
        return apiResponse($webhookSubscription, __('responses.item_created_successfully'), 201);
    }

    /**
     * Update webhook subscription
     *
     * @param  object  $request data from the form (name, url, event)
     * @param  string  $id id of the webhook subscription
     * @return array $webhookSubscription webhook subscription
     */
    public function updateWebhookSubscription(Request $request, $id)
    {
        $data = $request->all();
        $webhookSubscription = $this->webhookSubscriptionService->updateWebhookSubscription($id, $data);
        if (!$webhookSubscription) {
            return apiResponse(null, __('responses.data_not_found'), 404);
        }
        return apiResponse($webhookSubscription, __('responses.item_updated_successfully'));
    }

    /**
     * Delete a webhook subscription
     *
     * @param  string  $id id of the webhook subscription
     * @return array $webhookSubscription webhook subscription
     */
    public function deleteWebhookSubscription($id)
    {
        $webhookSubscription = $this->webhookSubscriptionService->deleteWebhookSubscription($id);
        if (!$webhookSubscription) {
            return apiResponse(null, __('responses.data_not_found'), 404);
        }
        return apiResponse($webhookSubscription, __('responses.item_deleted_successfully'));
    }
}
