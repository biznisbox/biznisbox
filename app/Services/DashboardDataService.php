<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardDataService
{
    private function getNumberOfCustomers()
    {
        return DB::table('partners')->where('type', 'customer')->orWhere('type', 'both')->count();
    }

    private function getNumberOfSuppliers()
    {
        return DB::table('partners')->where('type', 'supplier')->orWhere('type', 'both')->count();
    }

    private function getNumberOfEmployees()
    {
        return DB::table('employees')->count();
    }

    private function getNumberOfUnpaidInvoices()
    {
        return DB::table('invoices')
            ->whereNotIn('status', ['paid', 'partially_paid', 'draft'])
            ->count();
    }

    private function getNumberOfUnpaidBills()
    {
        return DB::table('bills')
            ->whereNotIn('status', ['paid', 'partially_paid', 'draft'])
            ->count();
    }

    private function getMonthIncomeAndExpenses($month = null, $year = null)
    {
        if ($month == null) {
            $month = date('m');
        }
        if ($year == null) {
            $year = date('Y');
        }
        $currentMonthIncome = DB::table('transactions')
            ->where('type', 'income')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');
        $currentMonthExpenses = DB::table('transactions')
            ->where('type', 'expense')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');
        return [
            'income' => round($currentMonthIncome, 2),
            'expense' => round($currentMonthExpenses, 2),
        ];
    }

    private function currentYearMonthlyIncomeAndExpenses()
    {
        $currentYear = date('Y');
        $monthlyIncome = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as total_amount'), DB::raw('MONTH(date) as month'))
            ->where('type', 'income')
            ->whereYear('date', $currentYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->get();
        $monthlyExpenses = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as total_amount'), DB::raw('MONTH(date) as month'))
            ->where('type', 'expense')
            ->whereYear('date', $currentYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->get();

        $char_data = [
            'income' => [],
            'expense' => [],
        ];

        foreach ($monthlyIncome as $income) {
            $char_data['income'][] = round($income->total_amount, 2);
        }
        foreach ($monthlyExpenses as $expense) {
            $char_data['expense'][] = round($expense->total_amount, 2);
        }
        return $char_data;
    }

    public function returnData($requiredData)
    {
        switch ($requiredData) {
            case 'number_of_customers':
                return $this->getNumberOfCustomers();
                break;
            case 'number_of_suppliers':
                return $this->getNumberOfSuppliers();
                break;
            case 'current_month_income_and_expenses':
                return $this->getMonthIncomeAndExpenses();
                break;
            case 'number_of_employees':
                return $this->getNumberOfEmployees();
                break;
            case 'number_of_unpaid_invoices':
                return $this->getNumberOfUnpaidInvoices();
                break;
            case 'number_of_unpaid_bills':
                return $this->getNumberOfUnpaidBills();
                break;
            case 'current_year_monthly_income_and_expenses':
                return $this->currentYearMonthlyIncomeAndExpenses();
                break;
            default:
                return null;
        }
    }
}
