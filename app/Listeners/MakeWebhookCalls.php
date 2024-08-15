<?php

namespace App\Listeners;

use App\Events\WebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\WebhookSubscription;
use Spatie\WebhookServer\WebhookCall;

class MakeWebhookCalls
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookEvent $event): void
    {
        $subscriptions = WebhookSubscription::query()->where('is_active', true)->oldest()->get();

        foreach ($subscriptions as $subscription) {
            if (!$subscription->isListenFor($event->name)) {
                continue;
            }

            $subscription->update(['last_called_at' => now()]);

            WebhookCall::create()
                ->url($subscription->url)
                ->payload([
                    'event' => $event->name,
                    'data' => $event->data,
                    'timestamp' => now()->timestamp,
                    'signature' => $subscription->signPayload($event->data),
                ])
                ->useHttpVerb($subscription->http_verb)
                ->useSecret($subscription->signature_secret_key)
                ->dispatch();
        }
    }
}
