<?php

namespace App\Services\Admin;

use App\Models\WebhookSubscription;

class WebhookSubscriptionService
{
    private $webhookSubscription;
    public function __construct()
    {
        $this->webhookSubscription = new WebhookSubscription();
    }

    public function getWebhookSubscriptions()
    {
        $webhookSubscriptions = $this->webhookSubscription->all();
        foreach ($webhookSubscriptions as $webhookSubscription) {
            $webhookSubscription->headers = $this->formatHeaderForFrontend($webhookSubscription->headers);
        }
        return $webhookSubscriptions;
    }

    public function getWebhookSubscription($id)
    {
        $webhookSubscription = $this->webhookSubscription->where('id', $id)->first();
        if (!$webhookSubscription) {
            return false;
        }
        $webhookSubscription->headers = $this->formatHeaderForFrontend($webhookSubscription->headers);
        return $webhookSubscription;
    }

    public function createWebhookSubscription($data)
    {
        $webhookSubscription = $this->webhookSubscription->create($data);
        return $webhookSubscription;
    }

    public function updateWebhookSubscription($id, $data)
    {
        $webhookSubscription = $this->webhookSubscription->find($id);
        if (!$webhookSubscription || !$webhookSubscription->can_be_edited) {
            return false;
        }
        $webhookSubscription->update($data);
        return $webhookSubscription;
    }

    public function deleteWebhookSubscription($id)
    {
        $webhookSubscription = $this->webhookSubscription->find($id);
        if (!$webhookSubscription) {
            return false;
        }
        $webhookSubscription->delete();
        return $webhookSubscription;
    }

    private function formatHeaderForFrontend($header)
    {
        $formattedHeader = [];
        foreach ($header as $h) {
            $formattedHeader[] = [
                'key' => $h['key'],
                'value' => $h['value'],
            ];
        }
        return $formattedHeader;
    }
}
