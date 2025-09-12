<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\PermissionRoleService;

/**
 * @group Permission Roles
 *
 * APIs for managing permission roles
 * @authenticated
 */
class PermissionRoleController extends Controller
{
    private $permissionRoleService;

    public function __construct(PermissionRoleService $permissionRoleService)
    {
        $this->permissionRoleService = $permissionRoleService;
    }

    /**
     * Get all roles
     *
     * @return array $roles All roles with permissions
     */
    public function getRoles()
    {
        $roles = $this->permissionRoleService->getRoles();
        if (!$roles) {
            return apiResponse($roles, __('responses.item_not_found'), 404);
        }
        return apiResponse($roles, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get role by id
     *
     * @param  string  $id id of the role
     * @return array $role role with permissions
     */

    public function getRole($id)
    {
        $role = $this->permissionRoleService->getRole($id);
        if (!$role) {
            return apiResponse($role, __('responses.item_not_found_with_id'), 404);
        }
        return apiResponse($role, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create a new role
     *
     * @param  object  $request data from the form (name and permissions)
     * @return array $role role with permissions
     */

    public function createRole(Request $request)
    {
        $data = $request->all();
        $role = $this->permissionRoleService->createRole($data);
        if (!$role) {
            return apiResponse($role, __('responses.item_not_created'), 400);
        }
        return apiResponse($role, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update a role
     *
     * @param  object $request data from the form (name and permissions)
     * @param  string  $id id of the role
     * @return array $role role with permissions
     */
    public function updateRole(Request $request, $id)
    {
        $data = $request->all();
        $role = $this->permissionRoleService->updateRole($data, $id);
        if (!$role) {
            return apiResponse($role, __('responses.item_not_found'), 404);
        }
        return apiResponse($role, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete a role
     *
     * @param  string  $id id of the role
     * @return array $role role with permissions
     */
    public function deleteRole($id)
    {
        $role = $this->permissionRoleService->deleteRole($id);
        if (!$role) {
            return apiResponse($role, __('responses.item_not_found'), 404);
        }
        return apiResponse($role, __('responses.item_deleted_successfully'), 200);
    }

    /**
     * Get all permissions
     *
     * @return array $permissions All permissions
     */
    public function getPermissions()
    {
        $permissions = $this->permissionRoleService->getPermissions();
        if (!$permissions) {
            return apiResponse($permissions, __('responses.item_not_found'), 404);
        }
        return apiResponse($permissions, __('responses.data_retrieved_successfully'), 200);
    }
}
