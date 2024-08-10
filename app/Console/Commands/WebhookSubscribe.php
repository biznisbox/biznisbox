<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WebhookSubscription;
use Illuminate\Support\Str;

class WebhookSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'biznisbox:webhook-subscribe {url : The URL of the webhook (external app)}
    {events : The events that webhook may listen ("*" for any event or comma separated values - for example: "order:new,order:updated")}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a subscribed external app to webhook';

    public function handle()
    {
        $url = trim($this->argument('url'));
        $events = trim($this->argument('events'));

        if (empty($url)) {
            $this->error('The URL is required!');
            return 1;
        }
        if (!Str::of($url)->startsWith('https://')) {
            $this->error('The URL must start with `https://`!');
            return 1;
        }
        if (empty($events)) {
            $events = '*';
        }

        $alreadyExists = WebhookSubscription::where('url', $url)->exists();
        if ($alreadyExists) {
            $this->error("The URL [{$url}] is already subscribed!");
            return 1;
        }

        $WebhookSubscription = WebhookSubscription::create([
            'url' => $url,
            'listen_events' => $events,
            'http_verb' => 'post',
            'headers' => ['Content-Type' => 'application/json'],
            'is_active' => true,
        ]);

        $this->info('OK, Webhook Subscription created.');
        $this->newLine();
        $this->line('> The signature secret key is:');
        $this->line("> <bg=magenta;fg=black>{$WebhookSubscription->signature_secret_key}</>");
        $this->newLine();
        $this->warn('(You have to pass this key to external app for checking signature)');

        return 0;
    }
}
