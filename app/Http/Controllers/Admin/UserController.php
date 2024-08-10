<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUsers()
    {
        $users = $this->userService->getUsers();
        if (!$users) {
            return api_response($users, __('responses.item_not_found'), 404);
        }
        return api_response($users, __('responses.data_retrieved_successfully'), 200);
    }

    public function getUser($id)
    {
        $user = $this->userService->getUser($id);
        if (!$user) {
            return api_response($user, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($user, __('responses.data_retrieved_successfully'), 200);
    }

    public function createUser(UserRequest $request)
    {
        $data = $request->all();
        $user = $this->userService->createUser($data);
        if (!$user) {
            return api_response($user, __('responses.item_not_created'), 400);
        }
        return api_response($user, __('responses.item_created_successfully'), 200);
    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->all();
        $user = $this->userService->updateUser($id, $data);
        if (!$user) {
            return api_response($user, __('responses.item_not_updated'), 400);
        }
        return api_response($user, __('responses.item_updated_successfully'), 200);
    }

    public function deleteUser($id)
    {
        $user = $this->userService->deleteUser($id);
        if (!$user) {
            return api_response($user, __('responses.item_not_deleted'), 400);
        }
        return api_response($user, __('responses.item_deleted_successfully'), 200);
    }

    public function resetPassword(Request $request, $id)
    {
        $data = $request->all();
        $user = $this->userService->resetPassword($id, $data);
        if (!$user) {
            return api_response($user, __('responses.password_reset_failed'), 400);
        }
        return api_response($user, __('responses.password_reset_successfully'), 200);
    }

    public function disable2fa($id)
    {
        $user = $this->userService->disable2fa($id);
        if (!$user) {
            return api_response($user, __('responses.two_factor_auth_disabled_error'), 400);
        }
        return api_response($user, __('responses.two_factor_auth_disabled'), 200);
    }
}
