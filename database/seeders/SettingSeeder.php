<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

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

        Setting::firstOrCreate(['key' => 'default_currency'], ['value' => 'EUR', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'default_lang'], ['value' => 'en', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'default_timezone'], ['value' => 'Europe/Ljubljana', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'date_format'], ['value' => 'DD.MM.YYYY', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'time_format'], ['value' => 'HH:mm', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'datetime_format'], ['value' => 'DD.MM.YYYY HH:mm', 'type' => 'string', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'show_barcode_on_documents'], ['value' => true, 'type' => 'boolean', 'is_public' => 1]);

        Setting::firstOrCreate(['key' => 'stripe_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'stripe_key'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'stripe_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        Setting::firstOrCreate(['key' => 'open_banking_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'open_banking_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'open_banking_secret'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        Setting::firstOrCreate(['key' => 'paypal_client_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'paypal_secret'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
        Setting::firstOrCreate(['key' => 'paypal_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'paypal_test_mode'], ['value' => true, 'type' => 'boolean', 'is_public' => 1]);
        Setting::firstOrCreate(['key' => 'paypal_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

        Setting::firstOrCreate(
            ['key' => 'quote_number_format'],
            ['value' => '{{TEXT:QUO}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'invoice_number_format'],
            ['value' => '{{TEXT:INV}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'payment_number_format'],
            ['value' => '{{TEXT:PAY}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'transaction_number_format'],
            ['value' => '{{TEXT:TRA}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'document_number_format'],
            ['value' => '{{TEXT:DOC}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'bill_number_format'],
            ['value' => '{{TEXT:BILL}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'product_number_format'],
            ['value' => '{{TEXT:PRO}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'partner_number_format'],
            ['value' => '{{TEXT:PAR}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'employee_number_format'],
            ['value' => '{{TEXT:EMP}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );

        Setting::firstOrCreate(
            ['key' => 'support_ticket_number_format'],
            ['value' => '{{TEXT:TICKET}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );
        Setting::firstOrCreate(
            ['key' => 'archive_number_format'],
            ['value' => '{{TEXT:DOC}}{{DELIMITER}}{{DATE:Y}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );

        Setting::firstOrCreate(
            ['key' => 'project_number_format'],
            ['value' => '{{TEXT:PROJ}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
        );

        Setting::firstOrCreate(['key' => 'default_payment_method'], ['value' => 'bank_transfer', 'type' => 'string', 'is_public' => 1]);

        Currency::firstOrCreate(['code' => 'EUR'], ['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 1, 'status' => 'active']);
    }
}
