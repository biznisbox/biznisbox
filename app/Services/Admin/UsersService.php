<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\UserDetails;
use Illuminate\Support\Facades\DB;

class UsersService
{
    public function __construct()
    {
        //
    }

    public function getUsers()
    {
        $users = new User();
        $users = $users->with('sessions', 'roles')->get();
        activity_log(user_data()->data->id, 'get users', null, 'App\Services\Admin\UsersService', 'getUsers');
        return api_response($users);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->sessions;
            $user->roles;
            $user->permissions = $user->getPermissionsViaRoles();
            activity_log(user_data()->data->id, 'get user', $id, 'App\Services\Admin\UsersService', 'getUser');
            return api_response($user);
        }
        return api_response(null, __('response.admin.user.not_found'), 400);
    }

    public function createUser($data)
    {
        try {
            Db::beginTransaction();
            $user = new User();
            $user = $user->createUser($data);
            if ($user) {
                $emails = $data['send_details_to'] ?? [];
                if ($emails) {
                    foreach ($emails as $email) {
                        $this->sendUserDetails($data, $email);
                    }
                }
                DB::commit();
                return api_response(null, __('response.admin.user.create_success'));
            }
            return api_response(null, __('response.admin.user.create_failed'), 400);
        } catch (\Exception $e) {
            Db::rollBack();
            return api_response(null, __('response.admin.user.create_failed'), 400);
        }
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->updateUser($id, $data);
            return api_response(null, __('response.admin.user.update_success'));
        }
        return api_response(null, __('response.admin.user.update_failed'), 400);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            if (user_data()->data->id === $user->id) {
                return api_response(null, __('response.admin.user.delete_failed_self_account'), 400);
            }
            $user->deleteUser($id);
            return api_response(null, __('response.admin.user.delete_success'));
        }
        return api_response(null, __('response.admin.user.delete_failed'), 400);
    }

    public function sendUserDetails($user, $email)
    {
        $validate = validator(['email' => $email], ['email' => 'required|email']);
        if ($validate->fails()) {
            return null;
        }
        Mail::to($email)->send(new UserDetails($user));
    }

    public function resetPassword($id, $data)
    {
        $user = User::find($id);
        if ($user) {
            $user = $user->resetPassword($user->id, $data['password']);

            $user = User::find($id);
            $user->password = $data['password']; // for sending email
            $emails = $data['send_details_to'] ?? [];
            if ($emails) {
                foreach ($emails as $email) {
                    $this->sendUserDetails($user, $email);
                }
            }
            activity_log(user_data()->data->id, 'reset user password', $id, 'App\Services\Admin\UsersService', 'resetPassword');
            return api_response(null, __('response.admin.user.password_reset_success'));
        }
        return api_response(null, __('response.admin.user.password_reset_failed'), 500);
    }
}
