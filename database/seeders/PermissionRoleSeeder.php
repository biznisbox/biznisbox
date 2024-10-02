<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // User permissions
        Permission::firstOrCreate(['name' => 'products', 'display_name' => 'permissions.products']);
        Permission::firstOrCreate(['name' => 'invoices', 'display_name' => 'permissions.invoices']);
        Permission::firstOrCreate(['name' => 'quotes', 'display_name' => 'permissions.quotes']);
        Permission::firstOrCreate(['name' => 'bills', 'display_name' => 'permissions.bills']);
        Permission::firstOrCreate(['name' => 'accounts', 'display_name' => 'permissions.accounts']);
        Permission::firstOrCreate(['name' => 'transactions', 'display_name' => 'permissions.transactions']);
        Permission::firstOrCreate(['name' => 'open_banking', 'display_name' => 'permissions.open_banking']);
        Permission::firstOrCreate(['name' => 'documents', 'display_name' => 'permissions.documents']);
        Permission::firstOrCreate(['name' => 'calendar', 'display_name' => 'permissions.calendar']);
        Permission::firstOrCreate(['name' => 'archive', 'display_name' => 'permissions.archive']);
        Permission::firstOrCreate(['name' => 'partners', 'display_name' => 'permissions.partners']);
        Permission::firstOrCreate(['name' => 'employees', 'display_name' => 'permissions.employees']);
        Permission::firstOrCreate(['name' => 'payments', 'display_name' => 'permissions.payments']);
        Permission::firstOrCreate(['name' => 'transactions_categories', 'display_name' => 'permissions.transactions_categories']);
        Permission::firstOrCreate(['name' => 'reports', 'display_name' => 'permissions.reports']);
        Permission::firstOrCreate(['name' => 'support', 'display_name' => 'permissions.support']);
        Permission::firstOrCreate(['name' => 'settings', 'display_name' => 'permissions.settings']);
        Permission::firstOrCreate(['name' => 'contracts', 'display_name' => 'permissions.contracts']);
        Permission::firstOrCreate(['name' => 'webhooks', 'display_name' => 'permissions.webhooks']);

        // Admin permissions
        Permission::firstOrCreate(['name' => 'admin', 'display_name' => 'permissions.admin']);
        Permission::firstOrCreate(['name' => 'admin_users', 'display_name' => 'permissions.admin_users']);
        Permission::firstOrCreate(['name' => 'admin_roles', 'display_name' => 'permissions.admin_roles']);
        Permission::firstOrCreate(['name' => 'admin_permissions', 'display_name' => 'permissions.admin_permissions']);
        Permission::firstOrCreate(['name' => 'admin_integrations', 'display_name' => 'permissions.admin_integrations']);
        Permission::firstOrCreate(['name' => 'admin_departments', 'display_name' => 'permissions.admin_departments']);
        Permission::firstOrCreate(['name' => 'admin_company_settings', 'display_name' => 'permissions.admin_company_settings']);
        Permission::firstOrCreate(['name' => 'admin_general_settings', 'display_name' => 'permissions.admin_general_settings']);
        Permission::firstOrCreate(['name' => 'admin_currencies', 'display_name' => 'permissions.admin_currencies']);
        Permission::firstOrCreate(['name' => 'admin_tax_rates', 'display_name' => 'permissions.admin_tax_rates']);
        Permission::firstOrCreate(['name' => 'admin_numbering', 'display_name' => 'permissions.admin_numbering']);
        Permission::firstOrCreate(['name' => 'admin_payment_methods', 'display_name' => 'permissions.admin_payment_methods']);
        Permission::firstOrCreate(['name' => 'admin_units', 'display_name' => 'permissions.admin_units']);
        Permission::firstOrCreate(['name' => 'admin_email_settings', 'display_name' => 'permissions.admin_email_settings']);
        Permission::firstOrCreate(['name' => 'admin_webhooks', 'display_name' => 'permissions.admin_webhooks']);

        // Client permissions
        Permission::firstOrCreate(['name' => 'client', 'display_name' => 'permissions.client']);

        // Create client role (for clients)
        $client = Role::firstOrCreate(['name' => 'client', 'display_name' => 'Client', 'system' => true]);
        $client->givePermissionTo(['client']);

        // Super admin role -> used for the main admin user
        $admin = Role::firstOrCreate(['name' => 'super_admin', 'display_name' => 'Super Admin', 'system' => true]);
        $admin->givePermissionTo(Permission::where('name', '!=', 'client')->get());

        // Bot role -> used for the bot user/system
        $bot = Role::firstOrCreate(['name' => 'bot', 'display_name' => 'Bot', 'system' => true]);
        $bot->givePermissionTo(Permission::where('name', '!=', 'client')->get());

        // User role -> used for the normal users (employees)
        $user = Role::firstOrCreate(['name' => 'user', 'display_name' => 'User']);
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
            'employees',
            'transactions_categories',
            'payments',
            'reports',
            'support',
            'contracts',
            'settings',
            'webhooks',
        ]);
    }
}
