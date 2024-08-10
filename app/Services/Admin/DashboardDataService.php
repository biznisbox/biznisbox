<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

class DashboardDataService
{
    public function getNumberOfUsers()
    {
        return DB::table('users')->count();
    }

    public function getNumberOfLoginsToday()
    {
        return DB::table('sessions')->whereDate('created_at', date('Y-m-d'))->count();
    }

    public function getGraphOfLoginsInLastMonth()
    {
        $logins = DB::table('sessions')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))
            ->groupBy('date')
            ->get();
        $dates = [];
        $counts = [];
        foreach ($logins as $login) {
            $dates[] = $login->date;
            $counts[] = $login->count;
        }
        return [
            'dates' => $dates,
            'counts' => $counts,
        ];
    }

    public function returnData($requiredData)
    {
        switch ($requiredData) {
            case 'number_of_users':
                return $this->getNumberOfUsers();
                break;
            case 'number_of_logins_today':
                return $this->getNumberOfLoginsToday();
                break;
            case 'graph_of_logins_in_last_month':
                return $this->getGraphOfLoginsInLastMonth();
                break;
            default:
                return null;
        }
    }
}
