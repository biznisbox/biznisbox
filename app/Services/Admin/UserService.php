<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getUsers()
    {
        $users = $this->userModel->getUsers();
        createActivityLog('retrieve', null, 'App\Models\User', 'getUsers');
        return $users;
    }

    public function getUser($id)
    {
        $user = $this->userModel->getUser($id);
        createActivityLog('retrieve', $id, 'App\Models\User', 'getUser');
        if (!$user) {
            return null;
        }
        return $user;
    }

    public function createUser($data)
    {
        $user = $this->userModel->createUser($data);
        return $user;
    }

    public function updateUser($id, $data)
    {
        $user = $this->userModel->updateUser($id, $data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->userModel->deleteUser($id);
        return $user;
    }

    public function resetPassword($id, $data)
    {
        $user = $this->userModel->resetPassword($id, $data);
        createActivityLog('resetPassword', $id, 'App\Models\User', 'User');
        return $user;
    }

    public function disable2fa($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            $user->update(['two_factor_auth' => 0]);
            DB::table('2fa')->where('user_id', $id)->delete();
        }
        createActivityLog('disable2fa', $id, 'App\Models\User', 'User');
        return $user;
    }
}
