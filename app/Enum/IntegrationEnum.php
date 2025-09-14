<?php

namespace App\Enum;
use App\Models\Setting;

enum IntegrationEnum: string
{
    case PAYPAL = 'paypal'; // PayPal payments
    case STRIPE = 'stripe'; // Stripe payments
    case COINBASE = 'coinbase'; // Coinbase payments
    case OPEN_BANKING = 'open_banking'; // Open Banking via Nordigen
    case VIES_VAT = 'vies_vat'; // VIES VAT validation

    public function label(): string
    {
        return match ($this) {
            self::PAYPAL => __('integrations.paypal'),
            self::STRIPE => __('integrations.stripe'),
            self::COINBASE => __('integrations.coinbase'),
            self::OPEN_BANKING => __('integrations.open_banking'),
            self::VIES_VAT => __('integrations.vies_vat'),
        };
    }

    public function prefix(): string
    {
        return match ($this) {
            self::PAYPAL => 'paypal_',
            self::STRIPE => 'stripe_',
            self::COINBASE => 'coinbase_',
            self::OPEN_BANKING => 'open_banking_',
            self::VIES_VAT => 'vies_vat_',
        };
    }

    public function settings(): array
    {
        return match ($this) {
            self::PAYPAL => [
                'client_id' => [],
                'secret' => [],
                'test_mode' => [
                    'value' => true,
                    'type' => 'boolean',
                ],
                'account_id' => [],
            ],
            self::STRIPE => [
                'key' => [],
                'account_id' => [],
            ],
            self::COINBASE => [
                'account_id' => [],
                'api_key' => [],
            ],
            self::OPEN_BANKING => [
                'id' => [],
                'secret' => [],
            ],
            self::VIES_VAT => [],
        };
    }

    public static function createIntegrationSettings(): void
    {
        $integrations = IntegrationEnum::cases();
        foreach ($integrations as $integration) {
            $settings = $integration->settings();
            Setting::firstOrCreate(
                ['key' => $integration->prefix() . 'available'],
                ['value' => false, 'type' => 'boolean', 'is_public' => 1],
            );

            foreach ($settings as $key => $setting) {
                $defaultValue = $setting['value'] ?? null;
                $type = $setting['type'] ?? 'string';
                $isPublic = $setting['is_public'] ?? 0;

                Setting::firstOrCreate(
                    ['key' => $integration->prefix() . $key],
                    ['value' => $defaultValue, 'type' => $type, 'is_public' => $isPublic],
                );
            }
        }
    }
}
