<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('settings');
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table
                ->string('key')
                ->unique()
                ->index();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, array, object
            $table->tinyInteger('is_public')->default(1);
            $table->timestamps();
        });

        // Add default settings
        DB::table('settings')->insert([
            ['key' => 'company_name', 'value' => 'Company Name', 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_address', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_zip', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_city', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_country', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_phone', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_email', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_logo', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_vat', 'value' => null, 'type' => 'string', 'is_public' => 1],
            ['key' => 'default_currency', 'value' => 'EUR', 'type' => 'string', 'is_public' => 1],
            ['key' => 'default_lang', 'value' => 'en', 'type' => 'string', 'is_public' => 1],
            ['key' => 'default_timezone', 'value' => 'Europe/Ljubljana', 'type' => 'string', 'is_public' => 1],
            ['key' => 'date_format', 'value' => 'DD.MM.YYYY', 'type' => 'string', 'is_public' => 1],
            ['key' => 'time_format', 'value' => 'HH:mm', 'type' => 'string', 'is_public' => 1],
            ['key' => 'datetime_format', 'value' => 'DD.MM.YYYY HH:mm', 'type' => 'string', 'is_public' => 1],
            ['key' => 'stripe_available', 'value' => false, 'type' => 'boolean', 'is_public' => 1],
            ['key' => 'stripe_key', 'value' => null, 'type' => 'string', 'is_public' => 0],
            ['key' => 'open_banking_available', 'value' => false, 'type' => 'boolean', 'is_public' => 1],
            ['key' => 'open_banking_id', 'value' => null, 'type' => 'string', 'is_public' => 0],
            ['key' => 'open_banking_secret', 'value' => null, 'type' => 'string', 'is_public' => 0],
            ['key' => 'paypal_client_id', 'value' => null, 'type' => 'string', 'is_public' => 0],
            ['key' => 'paypal_secret', 'value' => null, 'type' => 'string', 'is_public' => 0],
            ['key' => 'paypal_available', 'value' => false, 'type' => 'boolean', 'is_public' => 1],
            ['key' => 'paypal_test_mode', 'value' => true, 'type' => 'boolean', 'is_public' => 1],
            ['key' => 'estimate_number_format', 'value' => '{{TEXT:EST}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
            ['key' => 'invoice_number_format', 'value' => '{{TEXT:INV}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
            ['key' => 'payment_number_format', 'value' => '{{TEXT:PAY}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
            [
                'key' => 'transaction_number_format',
                'value' => '{{TEXT:TRA}}{{DELIMITER}}{{NUMBER:6}}',
                'type' => 'string',
                'is_public' => 1,
            ],
            ['key' => 'customer_number_format', 'value' => '{{TEXT:CUS}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
            ['key' => 'vendor_number_format', 'value' => '{{TEXT:VEN}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
            ['key' => 'bill_number_format', 'value' => '{{TEXT:BILL}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
