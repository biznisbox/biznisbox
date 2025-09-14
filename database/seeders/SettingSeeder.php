<?php

namespace Database\Seeders;

use App\Enum\IntegrationEnum;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Enum\PaymentGatewayEnum;
use App\Enum\SettingEnum;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set default currency
        Currency::firstOrCreate(['code' => 'EUR'], ['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 1, 'status' => 'active']);

        SettingEnum::createSettings();
        IntegrationEnum::createIntegrationSettings();
        PaymentGatewayEnum::createPaymentGatewayCategories();
        $this->updateEmailSettings();
    }

    private function updateEmailSettings(): void
    {
        $mailSettings = [
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
            'MAIL_SENDMAIL_PATH' => env('MAIL_SENDMAIL_PATH'),
        ];

        foreach ($mailSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'type' => 'string', 'is_public' => 0]);
        }
    }
}
