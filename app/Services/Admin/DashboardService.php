<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    protected function getNumberOfUsers()
    {
        return DB::table('users')->count();
    }

    protected function getNumberOfLoginsToday()
    {
        return DB::table('sessions')->whereDate('created_at', today())->count();
    }

    protected function getNumberOfActiveUsersToday()
    {
        return DB::table('users')->where('last_login_at', '>=', today())->count();
    }

    public function getDashboardData()
    {
        return [
            'users' => $this->getNumberOfUsers(),
            'logins' => $this->getNumberOfLoginsToday(),
            'active_users' => $this->getNumberOfActiveUsersToday(),
        ];
    }
}
