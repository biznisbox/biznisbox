<?php

namespace App\Enum;

use App\Models\Setting;

enum SettingEnum: string
{
    // Company Information Settings
    case COMPANY_NAME = 'company_name';
    case COMPANY_ADDRESS = 'company_address';
    case COMPANY_ZIP = 'company_zip';
    case COMPANY_CITY = 'company_city';
    case COMPANY_COUNTRY = 'company_country';
    case COMPANY_PHONE = 'company_phone';
    case COMPANY_EMAIL = 'company_email';
    case COMPANY_LOGO = 'company_logo';
    case COMPANY_VAT = 'company_vat';
    case COMPANY_COLOR = 'company_color';
    case COMPANY_WEBSITE = 'company_website';
    case COMPANY_DESCRIPTION = 'company_description';

    // Default Settings
    case DEFAULT_CURRENCY = 'default_currency';
    case DEFAULT_LANG = 'default_lang';
    case DEFAULT_TIMEZONE = 'default_timezone';
    case DATE_FORMAT = 'date_format';
    case TIME_FORMAT = 'time_format';
    case DATETIME_FORMAT = 'datetime_format';
    case WEEK_START = 'week_start';
    case EXCHANGE_RATE_PROVIDER = 'exchange_rate_provider';
    case DEFAULT_PAYMENT_METHOD = 'default_payment_method';

    // Document Settings
    case SHOW_BARCODE_ON_DOCUMENTS = 'show_barcode_on_documents';
    case SAVE_DOCUMENT_INTO_ARCHIVE = 'save_document_into_archive';

    // Mail Settings
    case MAIL_MAILER = 'mail_mailer';
    case MAIL_HOST = 'mail_host';
    case MAIL_PORT = 'mail_port';
    case MAIL_USERNAME = 'mail_username';
    case MAIL_PASSWORD = 'mail_password';
    case MAIL_ENCRYPTION = 'mail_encryption';
    case MAIL_FROM_ADDRESS = 'mail_from_address';
    case MAIL_FROM_NAME = 'mail_from_name';
    case MAIL_SENDMAIL_PATH = 'mail_sendmail_path';

    // Number Format Settings
    case QUOTE_NUMBER_FORMAT = 'quote_number_format';
    case INVOICE_NUMBER_FORMAT = 'invoice_number_format';
    case PAYMENT_NUMBER_FORMAT = 'payment_number_format';
    case TRANSACTION_NUMBER_FORMAT = 'transaction_number_format';
    case DOCUMENT_NUMBER_FORMAT = 'document_number_format';
    case BILL_NUMBER_FORMAT = 'bill_number_format';
    case PRODUCT_NUMBER_FORMAT = 'product_number_format';
    case PARTNER_NUMBER_FORMAT = 'partner_number_format';
    case CONTRACT_NUMBER_FORMAT = 'contract_number_format';
    case EMPLOYEE_NUMBER_FORMAT = 'employee_number_format';
    case SUPPORT_TICKET_NUMBER_FORMAT = 'support_ticket_number_format';
    case ARCHIVE_NUMBER_FORMAT = 'archive_number_format';
    case PROJECT_NUMBER_FORMAT = 'project_number_format';

    // Other Settings
    case ENABLE_CLIENT_PORTAL = 'enable_client_portal';
    case INVOICE_DUE_DAYS = 'invoice_due_days';
    case QUOTE_VALID_DAYS = 'quote_valid_days';
    case BILL_DUE_DAYS = 'bill_due_days';

    public function data(): array
    {
        return match ($this) {
            self::COMPANY_NAME => [
                'value' => 'BiznisBox',
            ],
            self::COMPANY_ADDRESS => [],
            self::COMPANY_ZIP => [],
            self::COMPANY_CITY => [],
            self::COMPANY_COUNTRY => [],
            self::COMPANY_PHONE => [],
            self::COMPANY_EMAIL => [],
            self::COMPANY_LOGO => [],
            self::COMPANY_VAT => [],
            self::COMPANY_COLOR => [
                'value' => '346bb4',
            ],
            self::COMPANY_WEBSITE => [],
            self::COMPANY_DESCRIPTION => [],
            self::DEFAULT_CURRENCY => [
                'value' => 'EUR',
            ],
            self::DEFAULT_LANG => [
                'value' => 'en',
            ],
            self::DEFAULT_TIMEZONE => [
                'value' => 'Europe/Berlin',
            ],
            self::DATE_FORMAT => [
                'value' => 'DD.MM.YYYY',
            ],
            self::TIME_FORMAT => [
                'value' => 'HH:mm',
            ],
            self::DATETIME_FORMAT => [
                'value' => 'DD.MM.YYYY HH:mm',
            ],
            self::WEEK_START => [
                'value' => 1,
                'type' => 'integer',
            ],
            self::EXCHANGE_RATE_PROVIDER => [
                'value' => 'ecb',
            ],
            self::DEFAULT_PAYMENT_METHOD => [
                'value' => 'cash',
            ],
            self::SHOW_BARCODE_ON_DOCUMENTS => [
                'value' => true,
                'type' => 'boolean',
            ],
            self::SAVE_DOCUMENT_INTO_ARCHIVE => [
                'value' => false,
                'type' => 'boolean',
            ],
            self::MAIL_MAILER => [
                'value' => 'smtp',
                'is_public' => 0,
            ],
            self::MAIL_HOST => [
                'value' => 'localhost',
                'is_public' => 0,
            ],
            self::MAIL_PORT => [
                'value' => 2525,
                'type' => 'integer',
                'is_public' => 0,
            ],
            self::MAIL_USERNAME => [
                'value' => null,
                'is_public' => 0,
            ],
            self::MAIL_PASSWORD => [
                'value' => null,
                'is_public' => 0,
            ],
            self::MAIL_ENCRYPTION => [
                'value' => 'tls',
                'is_public' => 0,
            ],
            self::MAIL_FROM_ADDRESS => [
                'value' => 'noreply@biznisbox.com',
                'is_public' => 0,
            ],
            self::MAIL_FROM_NAME => [
                'value' => 'BiznisBox',
                'is_public' => 0,
            ],
            self::MAIL_SENDMAIL_PATH => [
                'value' => '/usr/sbin/sendmail -bs',
                'is_public' => 0,
            ],
            self::QUOTE_NUMBER_FORMAT => [
                'value' => '{{TEXT:QUO}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::INVOICE_NUMBER_FORMAT => [
                'value' => '{{TEXT:INV}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::PAYMENT_NUMBER_FORMAT => [
                'value' => '{{TEXT:PAY}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::TRANSACTION_NUMBER_FORMAT => [
                'value' => '{{TEXT:TRA}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::DOCUMENT_NUMBER_FORMAT => [
                'value' => '{{TEXT:DOC}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::BILL_NUMBER_FORMAT => [
                'value' => '{{TEXT:BILL}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::PRODUCT_NUMBER_FORMAT => [
                'value' => '{{TEXT:PRO}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::PARTNER_NUMBER_FORMAT => [
                'value' => '{{TEXT:PAR}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::CONTRACT_NUMBER_FORMAT => [
                'value' => '{{TEXT:CON}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::EMPLOYEE_NUMBER_FORMAT => [
                'value' => '{{TEXT:EMP}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::SUPPORT_TICKET_NUMBER_FORMAT => [
                'value' => '{{TEXT:TICKET}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::ARCHIVE_NUMBER_FORMAT => [
                'value' => '{{TEXT:DOC}}{{DELIMITER}}{{DATE:Y}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::PROJECT_NUMBER_FORMAT => [
                'value' => '{{TEXT:PROJ}}{{DELIMITER}}{{NUMBER:6}}',
                'is_public' => 0,
            ],
            self::ENABLE_CLIENT_PORTAL => [
                'value' => true,
                'type' => 'boolean',
            ],
            self::INVOICE_DUE_DAYS => [
                'value' => 14,
                'type' => 'integer',
            ],
            self::QUOTE_VALID_DAYS => [
                'value' => 30,
                'type' => 'integer',
            ],
            self::BILL_DUE_DAYS => [
                'value' => 30,
                'type' => 'integer',
            ],
        };
    }

    public static function createSettings(): void
    {
        $settings = SettingEnum::cases();
        foreach ($settings as $setting) {
            $settingData = $setting->data();
            // Extract values with defaults
            $defaultValue = $settingData['value'] ?? null;
            $type = $settingData['type'] ?? 'string';
            $isPublic = $settingData['is_public'] ?? 1;

            Setting::firstOrCreate(['key' => $setting->value], ['value' => $defaultValue, 'type' => $type, 'is_public' => $isPublic]);
        }
    }
}
