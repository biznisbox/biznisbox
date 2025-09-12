<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Category;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::firstOrCreate(['key' => 'company_name'], ['value' => 'Company Name', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_address'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_zip'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_city'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_country'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_phone'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_email'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_logo'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_vat'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_color'], ['value' => '346bb4', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_website'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'company_description'], ['value' => null, 'type' => 'string', 'is_public' => 1]);

        // Default settings
        Setting::firstOrCreate(['key' => 'default_currency'], ['value' => 'EUR', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'default_lang'], ['value' => 'en', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'default_timezone'], ['value' => 'Europe/Ljubljana', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'date_format'], ['value' => 'DD.MM.YYYY', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'time_format'], ['value' => 'HH:mm', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'datetime_format'], ['value' => 'DD.MM.YYYY HH:mm', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'week_start'], ['value' => 1, 'type' => 'integer', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'show_barcode_on_documents'], ['value' => true, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'save_document_into_archive'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);

        // Stripe settings
        Setting::firstOrCreate(['key' => 'stripe_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'stripe_key'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'stripe_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        // Open Banking settings
        Setting::firstOrCreate(['key' => 'open_banking_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'open_banking_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'open_banking_secret'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        // PayPal settings
        Setting::firstOrCreate(['key' => 'paypal_client_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'paypal_secret'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'paypal_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'paypal_test_mode'], ['value' => true, 'type' => 'boolean', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'paypal_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        // Coinbase settings
        Setting::firstOrCreate(['key' => 'coinbase_api_key'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'coinbase_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'coinbase_test_mode'], ['value' => true, 'type' => 'boolean', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'coinbase_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        // Mail settings
        Setting::firstOrCreate(['key' => 'mail_mailer'], ['value' => 'smtp', 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_host'], ['value' => 'localhost', 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_port'], ['value' => 2525, 'type' => 'integer', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_username'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_password'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_encryption'], ['value' => 'tls', 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_from_address'], ['value' => 'noreply@example.com', 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'mail_from_name'], ['value' => 'BiznisBox', 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(
            ['key' => 'mail_sendmail_path'],
            ['value' => '/usr/sbin/sendmail -bs', 'type' => 'string', 'is_public' => 0],
        );

        // Set default number formats
        Setting::firstOrCreate(
            ['key' => 'quote_number_format'],
            ['value' => '{{TEXT:QUO}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'invoice_number_format'],
            ['value' => '{{TEXT:INV}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'payment_number_format'],
            ['value' => '{{TEXT:PAY}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'transaction_number_format'],
            ['value' => '{{TEXT:TRA}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'document_number_format'],
            ['value' => '{{TEXT:DOC}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'bill_number_format'],
            ['value' => '{{TEXT:BILL}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'product_number_format'],
            ['value' => '{{TEXT:PRO}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'partner_number_format'],
            ['value' => '{{TEXT:PAR}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'employee_number_format'],
            ['value' => '{{TEXT:EMP}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );

        Setting::firstOrCreate(
            ['key' => 'support_ticket_number_format'],
            ['value' => '{{TEXT:TICKET}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );
        Setting::firstOrCreate(
            ['key' => 'archive_number_format'],
            ['value' => '{{TEXT:DOC}}{{DELIMITER}}{{DATE:Y}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );

        Setting::firstOrCreate(
            ['key' => 'project_number_format'],
            ['value' => '{{TEXT:PROJ}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );

        Setting::firstOrCreate(
            ['key' => 'contract_number_format'],
            ['value' => '{{TEXT:CON}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        );

        // Set default payment method
        Setting::firstOrCreate(['key' => 'default_payment_method'], ['value' => 'bank_transfer', 'type' => 'string', 'is_public' => 1]);

        // Set default due days
        Setting::firstOrCreate(['key' => 'invoice_due_days'], ['value' => 14, 'type' => 'integer', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'quote_valid_days'], ['value' => 30, 'type' => 'integer', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'bill_due_days'], ['value' => 30, 'type' => 'integer', 'is_public' => 1]);

        // Set default currency
        Currency::firstOrCreate(['code' => 'EUR'], ['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 1, 'status' => 'active']);

        // Set default exchange rate provider
        Setting::firstOrCreate(['key' => 'exchange_rate_provider'], ['value' => 'ecb', 'type' => 'string', 'is_public' => 1]);

        // Seed default payment methods
        Category::firstOrCreate(
            ['additional_info' => 'paypal'],
            ['module' => 'payment_method', 'icon' => 'fab fa-paypal', 'name' => 'PayPal', 'color' => '003087'],
        );
        Category::firstOrCreate(
            ['additional_info' => 'stripe'],
            ['module' => 'payment_method', 'icon' => 'fab fa-stripe', 'name' => 'Stripe', 'color' => '635BFF'],
        );

        Category::firstOrCreate(
            ['additional_info' => 'bank_transfer'],
            ['module' => 'payment_method', 'icon' => 'fas fa-university', 'name' => 'Bank Transfer', 'color' => '346bb4'],
        );

        Category::firstOrCreate(
            ['additional_info' => 'cash'],
            ['module' => 'payment_method', 'icon' => 'fas fa-money-bill-wave', 'name' => 'Cash', 'color' => '3cba54'],
        );

        Category::firstOrCreate(
            ['additional_info' => 'coinbase'],
            ['module' => 'payment_method', 'icon' => 'fab fa-bitcoin', 'name' => 'Coinbase', 'color' => 'ff9900'],
        );

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
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'type' => 'string', 'is_public' => 1]);
        }
    }
}
