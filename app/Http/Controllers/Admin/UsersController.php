<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\UsersService;

class UsersController extends Controller
{
    protected $usersService;
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function getUsers()
    {
        return $this->usersService->getUsers();
    }

    public function getUser($id)
    {
        return $this->usersService->getUser($id);
    }

    public function createUser(Request $request)
    {
        $data = $request->all();
        return $this->usersService->createUser($data);
    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->all();
        return $this->usersService->updateUser($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->usersService->deleteUser($id);
    }

    public function resetUserPassword(Request $request, $id)
    {
        return $this->usersService->resetPassword($id, $request->all());
    }
}
