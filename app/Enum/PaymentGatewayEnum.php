<?php

namespace App\Enum;

use App\Models\Category;

enum PaymentGatewayEnum: string
{
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';
    case COINBASE = 'coinbase';

    public function label(): string
    {
        return match ($this) {
            self::STRIPE => __('pdf.payment_methods.stripe'),
            self::PAYPAL => __('pdf.payment_methods.paypal'),
            self::COINBASE => __('pdf.payment_methods.coinbase'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::STRIPE => 'fab fa-stripe',
            self::PAYPAL => 'fab fa-paypal',
            self::COINBASE => 'fab fa-bitcoin',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::STRIPE => '635BFF',
            self::PAYPAL => '003087',
            self::COINBASE => 'ff9900',
        };
    }

    public static function toArray(): array
    {
        return [self::STRIPE->value, self::PAYPAL->value, self::COINBASE->value];
    }

    public static function createPaymentGatewayCategories(): void
    {
        $paymentGateways = PaymentGatewayEnum::cases();
        foreach ($paymentGateways as $gateway) {
            Category::firstOrCreate(
                ['additional_info' => $gateway->value],
                ['module' => 'payment_method', 'icon' => $gateway->icon(), 'name' => $gateway->label(), 'color' => $gateway->color()],
            );
        }
    }
}
