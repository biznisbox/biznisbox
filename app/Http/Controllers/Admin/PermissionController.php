<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function getRoles()
    {
        return $this->permissionService->getRoles();
    }

    public function getRoleById($id)
    {
        return $this->permissionService->getRoleById($id);
    }

    public function createRole(Request $request)
    {
        return $this->permissionService->createRole($request);
    }

    public function updateRole(Request $request, $id)
    {
        return $this->permissionService->updateRole($request, $id);
    }

    public function deleteRole($id)
    {
        return $this->permissionService->deleteRole($id);
    }

    public function getPermissions()
    {
        return $this->permissionService->getPermissions();
    }
}
