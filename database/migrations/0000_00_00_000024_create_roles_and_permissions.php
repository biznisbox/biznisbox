<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Role;
use App\Models\Permission;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create(['name' => 'super_admin', 'display_name' => 'Super Admin']);
        Role::create(['name' => 'user', 'display_name' => 'User']);

        Permission::create(['name' => 'products', 'display_name' => 'Products']);
        Permission::create(['name' => 'invoices', 'display_name' => 'Invoices']);
        Permission::create(['name' => 'customers', 'display_name' => 'Customers']);
        Permission::create(['name' => 'estimates', 'display_name' => 'Estimates']);
        Permission::create(['name' => 'vendors', 'display_name' => 'Vendors']);
        Permission::create(['name' => 'bills', 'display_name' => 'Bills']);
        Permission::create(['name' => 'accounts', 'display_name' => 'Accounts']);
        Permission::create(['name' => 'transactions', 'display_name' => 'Transactions']);
        Permission::create(['name' => 'open_banking', 'display_name' => 'Open Banking']);
        Permission::create(['name' => 'documents', 'display_name' => 'Documents']);
        Permission::create(['name' => 'calendar', 'display_name' => 'Calendar']);
        Permission::create(['name' => 'edit_own_profile', 'display_name' => 'Edit own profile']);
        Permission::create(['name' => 'change_own_password', 'display_name' => 'Change own password']);

        // Admin permissions
        Permission::create(['name' => 'admin', 'display_name' => 'Admin']); // Must had this permission to access admin panel
        Permission::create(['name' => 'admin_users', 'display_name' => 'Admin Users']);
        Permission::create(['name' => 'admin_roles', 'display_name' => 'Admin Roles']);
        Permission::create(['name' => 'admin_permissions', 'display_name' => 'Admin Permissions']);
        Permission::create(['name' => 'admin_integrations', 'display_name' => 'Admin Integrations']);
        Permission::create(['name' => 'admin_company_settings', 'display_name' => 'Admin Company Settings']);
        Permission::create(['name' => 'admin_general_settings', 'display_name' => 'Admin General Settings']);
        Permission::create(['name' => 'admin_currencies', 'display_name' => 'Admin Currencies']);
        Permission::create(['name' => 'admin_tax_rates', 'display_name' => 'Admin Tax Rates']);
        Permission::create(['name' => 'admin_numbering', 'display_name' => 'Admin Numbering']);
        Permission::create(['name' => 'admin_payment_methods', 'display_name' => 'Admin Payment Methods']);

        // Assign all permissions to admin role
        $admin = Role::where('name', 'super_admin')->first();
        $admin->givePermissionTo(Permission::all());

        // Assign default permissions to user role
        $user = Role::where('name', 'user')->first();
        $user->givePermissionTo([
            'products',
            'invoices',
            'customers',
            'estimates',
            'vendors',
            'bills',
            'accounts',
            'transactions',
            'open_banking',
            'documents',
            'calendar',
            'edit_own_profile',
            'change_own_password',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
