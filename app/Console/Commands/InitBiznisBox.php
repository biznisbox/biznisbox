<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Settings;
use App\Models\Currencies as Currency;
use App\Models\Units as Unit;
use App\Models\Accounts as Account;

class InitBiznisBox extends Command
{
    // This command is used for initializing BiznisBox after installation or update.
    // It will create all default data and settings.

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'biznisbox:init {--update}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Initialize BiznisBox after installation or update.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('update')) {
            $this->info('Updating default data BiznisBox...');
        } else {
            $this->info('Initializing BiznisBox...');
        }

        // Migrate database
        $this->info('Migrating database...');
        $this->call('migrate');

        if (!$this->option('update')) {
            $this->info('Seeding database...');
            $this->call('db:seed', [
                '--class' => 'WorldSeeder',
            ]);
        }

        // Create default roles
        if ($this->option('update')) {
            $this->info('Updating default roles...');
        } else {
            $this->info('Creating default roles...');
            Role::firstOrCreate(['name' => 'super_admin'], ['display_name' => 'Super Admin']);
            Role::firstOrCreate(['name' => 'user'], ['display_name' => 'User']);
        }

        // User permissions
        Permission::firstOrCreate(['name' => 'products', 'display_name' => 'Products']);
        Permission::firstOrCreate(['name' => 'invoices', 'display_name' => 'Invoices']);
        Permission::firstOrCreate(['name' => 'quotes', 'display_name' => 'Quotes']);
        Permission::firstOrCreate(['name' => 'bills', 'display_name' => 'Bills']);
        Permission::firstOrCreate(['name' => 'accounts', 'display_name' => 'Accounts']);
        Permission::firstOrCreate(['name' => 'transactions', 'display_name' => 'Transactions']);
        Permission::firstOrCreate(['name' => 'open_banking', 'display_name' => 'Open Banking']);
        Permission::firstOrCreate(['name' => 'documents', 'display_name' => 'Documents']);
        Permission::firstOrCreate(['name' => 'calendar', 'display_name' => 'Calendar']);
        Permission::firstOrCreate(['name' => 'archive', 'display_name' => 'Archive']);
        Permission::firstOrCreate(['name' => 'partners', 'display_name' => 'Partners']);
        Permission::firstOrCreate(['name' => 'transactions_categories', 'display_name' => 'Transactions Categories']);
        Permission::firstOrCreate(['name' => 'edit_own_profile', 'display_name' => 'Edit own profile']);
        Permission::firstOrCreate(['name' => 'change_own_password', 'display_name' => 'Change own password']);

        // Admin permissions
        Permission::firstOrCreate(['name' => 'admin', 'display_name' => 'Admin']); // Must had this permission to access admin panel
        Permission::firstOrCreate(['name' => 'admin_users', 'display_name' => 'Admin Users']);
        Permission::firstOrCreate(['name' => 'admin_roles', 'display_name' => 'Admin Roles']);
        Permission::firstOrCreate(['name' => 'admin_permissions', 'display_name' => 'Admin Permissions']);
        Permission::firstOrCreate(['name' => 'admin_integrations', 'display_name' => 'Admin Integrations']);
        Permission::firstOrCreate(['name' => 'admin_departments', 'display_name' => 'Admin Departments']);
        Permission::firstOrCreate(['name' => 'admin_company_settings', 'display_name' => 'Admin Company Settings']);
        Permission::firstOrCreate(['name' => 'admin_general_settings', 'display_name' => 'Admin General Settings']);
        Permission::firstOrCreate(['name' => 'admin_currencies', 'display_name' => 'Admin Currencies']);
        Permission::firstOrCreate(['name' => 'admin_tax_rates', 'display_name' => 'Admin Tax Rates']);
        Permission::firstOrCreate(['name' => 'admin_numbering', 'display_name' => 'Admin Numbering']);
        Permission::firstOrCreate(['name' => 'admin_payment_methods', 'display_name' => 'Admin Payment Methods']);

        // Assign all permissions to admin role
        $admin = Role::where('name', 'super_admin')->first();
        $admin->givePermissionTo(Permission::all());

        // Assign default permissions to user role if not updating - this will prevent overwriting user permissions
        if (!$this->option('update')) {
            $this->info('Assigning default permissions to user role...');
            $user = Role::where('name', 'user')->first();
            $user->givePermissionTo([
                'products',
                'invoices',
                'quotes',
                'bills',
                'accounts',
                'transactions',
                'open_banking',
                'documents',
                'calendar',
                'archive',
                'partners',
                'edit_own_profile',
                'change_own_password',
            ]);
        }

        // Create default accounts if not updating - this will prevent overwriting user accounts
        if (!$this->option('update')) {
            $this->info('Creating default accounts...');
            Account::firstOrCreate([
                'name' => 'Default account',
                'type' => 'bank_account',
                'is_default' => 1,
                'is_active' => 1,
                'opening_balance' => 0,
                'current_balance' => 0,
                'description' => 'Default account',
                'currency' => 'EUR',
            ]);
            Account::firstOrCreate([
                'name' => 'PayPal',
                'type' => 'online_account',
                'is_default' => 0,
                'is_active' => 0,
                'integration' => 'paypal',
                'opening_balance' => 0,
                'current_balance' => 0,
                'description' => 'PayPal account',
                'currency' => 'EUR',
            ]);
            Account::firstOrCreate([
                'name' => 'Stripe',
                'type' => 'online_account',
                'is_default' => 0,
                'is_active' => 0,
                'integration' => 'stripe',
                'opening_balance' => 0,
                'current_balance' => 0,
                'description' => 'Stripe account',
                'currency' => 'EUR',
            ]);
        }

        // Create default settings if not updating - this will prevent overwriting user settings
        if (!$this->option('update')) {
            $this->info('Creating default settings...');
            Settings::firstOrCreate(['key' => 'company_name'], ['value' => 'Company Name', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_address'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_zip'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_city'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_country'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_phone'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_email'], ['value' => null, 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_logo'], ['value' => '/biznisbox_logo.png', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'company_vat'], ['value' => null, 'type' => 'string', 'is_public' => 1]);

            Settings::firstOrCreate(['key' => 'default_currency'], ['value' => 'EUR', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'default_lang'], ['value' => 'en', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'default_timezone'], ['value' => 'Europe/Ljubljana', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'date_format'], ['value' => 'DD.MM.YYYY', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'time_format'], ['value' => 'HH:mm', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'datetime_format'], ['value' => 'DD.MM.YYYY HH:mm', 'type' => 'string', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'show_barcode_on_documents'], ['value' => true, 'type' => 'boolean', 'is_public' => 1]);

            Settings::firstOrCreate(['key' => 'stripe_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'stripe_key'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
            Settings::firstOrCreate(['key' => 'stripe_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

            Settings::firstOrCreate(['key' => 'open_banking_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'open_banking_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
            Settings::firstOrCreate(['key' => 'open_banking_secret'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

            Settings::firstOrCreate(['key' => 'paypal_client_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
            Settings::firstOrCreate(['key' => 'paypal_secret'], ['value' => null, 'type' => 'string', 'is_public' => 0]);
            Settings::firstOrCreate(['key' => 'paypal_available'], ['value' => false, 'type' => 'boolean', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'paypal_test_mode'], ['value' => true, 'type' => 'boolean', 'is_public' => 1]);
            Settings::firstOrCreate(['key' => 'paypal_account_id'], ['value' => null, 'type' => 'string', 'is_public' => 0]);

            Settings::firstOrCreate(
                ['key' => 'quote_number_format'],
                ['value' => '{{TEXT:QUO}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'invoice_number_format'],
                ['value' => '{{TEXT:INV}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'payment_number_format'],
                ['value' => '{{TEXT:PAY}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'transaction_number_format'],
                ['value' => '{{TEXT:TRA}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'document_number_format'],
                ['value' => '{{TEXT:DOC}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'bill_number_format'],
                ['value' => '{{TEXT:BILL}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'product_number_format'],
                ['value' => '{{TEXT:PRO}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
            Settings::firstOrCreate(
                ['key' => 'partner_number_format'],
                ['value' => '{{TEXT:PAR}}{{DELIMITER}}{{NUMBER:6}}', 'type' => 'string', 'is_public' => 1]
            );
        }

        // Add default currencies if not updating - this will prevent overwriting user currencies
        if (!$this->option('update')) {
            $this->info('Adding default currencies...');
            Currency::firstOrCreate(['code' => 'EUR'], ['name' => 'Euro', 'symbol' => '€', 'is_default' => 1, 'rate' => 1]);
            Currency::firstOrCreate(['code' => 'USD'], ['name' => 'US Dollar', 'symbol' => '$', 'is_default' => 0, 'rate' => 1.19]);
            Currency::firstOrCreate(['code' => 'GBP'], ['name' => 'British Pound', 'symbol' => '£', 'is_default' => 0, 'rate' => 0.86]);
        }

        // Add default units if not updating - this will prevent overwriting user units
        if (!$this->option('update')) {
            $this->info('Adding default units...');
            Unit::firstOrCreate(['symbol' => 'pcs', 'name' => 'Pieces']);
            Unit::firstOrCreate(['symbol' => 'kg', 'name' => 'Kilograms']);
            Unit::firstOrCreate(['symbol' => 'm', 'name' => 'Meters']);
            Unit::firstOrCreate(['symbol' => 'l', 'name' => 'Liters']);
            Unit::firstOrCreate(['symbol' => 'm2', 'name' => 'Square Meters']);
            Unit::firstOrCreate(['symbol' => 'm3', 'name' => 'Cubic Meters']);
            Unit::firstOrCreate(['symbol' => 'km', 'name' => 'Kilometers']);
            Unit::firstOrCreate(['symbol' => 'cm', 'name' => 'Centimeters']);
            Unit::firstOrCreate(['symbol' => 'mm', 'name' => 'Millimeters']);
            Unit::firstOrCreate(['symbol' => 'g', 'name' => 'Grams']);
            Unit::firstOrCreate(['symbol' => 'mg', 'name' => 'Milligrams']);
            Unit::firstOrCreate(['symbol' => 't', 'name' => 'Tons']);
            Unit::firstOrCreate(['symbol' => 'box', 'name' => 'Box']);
            Unit::firstOrCreate(['symbol' => 'plt', 'name' => 'Pallet']);
            Unit::firstOrCreate(['symbol' => 'd', 'name' => 'Days']);
            Unit::firstOrCreate(['symbol' => 'w', 'name' => 'Weeks']);
            Unit::firstOrCreate(['symbol' => 'm', 'name' => 'Months']);
            Unit::firstOrCreate(['symbol' => 'y', 'name' => 'Years']);
            Unit::firstOrCreate(['symbol' => 's', 'name' => 'Seconds']);
            Unit::firstOrCreate(['symbol' => 'min', 'name' => 'Minutes']);
            Unit::firstOrCreate(['symbol' => 'h', 'name' => 'Hours']);
        }

        if (!$this->option('update')) {
            if ($this->confirm('Would you like to create a super admin user?')) {
                $email = $this->ask('Enter email');
                $password = $this->secret('Enter password');
                $name = $this->ask('Enter name');
                $surname = $this->ask('Enter surname');

                $this->info('Creating super admin user...');
                $user = $this->call('biznisbox:create-user', [
                    'email' => $email,
                    'password' => $password,
                    'name' => $name,
                    '--surname' => $surname,
                    '--role' => 'super_admin',
                ]);
            }
        }
        $this->info('BiznisBox initialized successfully.');
    }
}
