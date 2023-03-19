<?php

namespace App\Services\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionService
{
    /**
     * Get all roles
     * @return array $roles All roles with permissions
     */
    public function getRoles()
    {
        $roles = Role::with('permissions')->get();
        return api_response($roles);
    }

    /**
     * Get role by id
     * @param  string  $id id of the role
     * @return array $role role with permissions
     */
    public function getRoleById($id)
    {
        $role = Role::findOrFail($id);
        $all_role_permissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->select('permissions.name')
            ->get();

        $role->permissions = format_permissions($all_role_permissions);
        return api_response($role);
    }

    /**
     * Create a new role
     * @param  array  $request data from the form (name and permissions)
     * @return array $role role with permissions
     */
    public function createRole($request)
    {
        if ($request['name'] == 'super_admin') {
            return api_response(null, __('response.admin.role.super_admin_cannot_be_created'), 400);
        }

        $role = Role::create([
            'name' => Str::slug($request['name'], '_'),
            'display_name' => $request['name'],
            'description' => $request['description'],
        ]);
        $role->syncPermissions($request['permissions']);
        return api_response($role, __('response.admin.role.create_success'));
    }

    /**
     * Update a role
     * @param  array  $request data from the form (name and permissions)
     * @param  string  $id id of the role
     * @return array $role role with permissions
     */

    public function updateRole($request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name == 'super_admin') {
            return api_response(null, __('response.admin.role.super_admin_cannot_be_updated'), 400);
        }

        // Get all users with this role
        $users = User::role($role->name)->get();

        $role->name = Str::slug($request['name'], '_');
        $role->description = $request['description'];
        $role->display_name = $request['name'];
        $role->syncPermissions($request['permissions']);
        $role->save();

        // Sync users with this role
        foreach ($users as $user) {
            $user->syncRoles($role->name);
        }

        return api_response($role, __('response.admin.role.update_success'));
    }

    /**
     * Delete a role
     * @param  uuid  $id id of the role
     *
     * @return void
     */
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name == 'super_admin') {
            return api_response(null, __('response.admin.role.super_admin_cannot_be_deleted'), 400);
        }

        $role->delete();
        return api_response($role, __('response.admin.role.delete_success'));
    }

    /**
     * Get all permissions
     * @return array $permissions All permissions
     */
    public function getPermissions()
    {
        $permissions = Permission::all();
        return api_response($permissions);
    }
}
