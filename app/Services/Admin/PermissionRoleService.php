<?php

namespace App\Services\Admin;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PermissionRoleService
{
    /**
     * Get all roles
     * @return array $roles All roles with permissions
     */
    public function getRoles()
    {
        $roles = Role::with('permissions')->get();
        createActivityLog('retrieve', null, Role::$modelName, 'Role');
        return $roles;
    }

    /**
     * Get role by id
     * @param  string  $id id of the role
     * @return array $role role with permissions
     */
    public function getRole($id)
    {
        $role = Role::with('users:id,first_name,last_name,picture,email')->findOrFail($id);
        $all_role_permissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->select('permissions.name')
            ->get();

        $role->permissions = formatPermissions($all_role_permissions);
        createActivityLog('retrieve', $id, Role::$modelName, 'Role');
        return $role;
    }

    /**
     * Create a new role
     * @param  array  $request data from the form (name and permissions)
     * @return array $role role with permissions
     */
    public function createRole($request)
    {
        if ($request['name'] == 'super_admin' || $request['name'] == 'client') {
            return [
                'error' => __('responses.unable_to_create_role'),
                'status' => 400,
            ];
        }

        foreach ($request['permissions'] as $permission) {
            if (Str::contains($permission, 'admin')) {
                array_push($request['permissions'], 'admin');
            }
        }

        $role = Role::create([
            'name' => Str::slug($request['name'], '_'),
            'display_name' => $request['name'],
            'description' => $request['description'],
            'system' => false,
        ]);
        $role->syncPermissions($request['permissions']);
        return $role;
    }

    /**
     * Update a role
     * @param  array $request data from the form (name and permissions)
     * @param  string $id id of the role
     * @return array $role role with permissions
     */

    public function updateRole($data, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->system) {
            return [
                'error' => __('responses.system_role_can_edit'),
                'status' => 400,
            ];
        }

        foreach ($data['permissions'] as $permission) {
            if (Str::contains($permission, 'admin')) {
                array_push($data['permissions'], 'admin');
            }
        }

        $users = User::with('roles')
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role->name);
            })
            ->get();
        // Get all users with this role
        $role->name = Str::slug($data['name'], '-');
        $role->description = $data['description'];
        $role->display_name = $data['name'];
        $role->syncPermissions($data['permissions']);
        $role->save();

        // Sync users with this role
        foreach ($users as $user) {
            $user->syncRoles($role->name);
        }

        return $role;
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
        if ($role->system) {
            return [
                'error' => __('responses.system_role_can_delete'),
                'status' => 400,
            ];
        }

        // Get all users with this role
        $users = User::with('roles')
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role->name);
            })
            ->get();

        // Sync users with this role - remove role
        foreach ($users as $user) {
            $user->syncRoles();
        }

        $role->delete();
        return $role;
    }

    /**
     * Get all permissions
     * @return array $permissions All permissions
     */
    public function getPermissions()
    {
        $permissions = Permission::all();
        return $permissions;
    }
}
