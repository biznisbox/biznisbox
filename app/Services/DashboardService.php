<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    private function getNumberOfProducts()
    {
        return DB::table('products')->count();
    }

    private function getNumberOfCustomers()
    {
        return DB::table('customers')->count();
    }

    private function getNumberOfUnpaidInvoices()
    {
        return DB::table('invoices')
            ->where('status', 'unpaid')
            ->orWhere('status', 'sent')
            ->count();
    }

    private function getUnpaidInvoices()
    {
        return DB::table('invoices')
            ->select('id', 'number', 'date', 'due_date', 'total', 'status')
            ->where('status', 'unpaid')
            ->orWhere('status', 'sent')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
    }

    private function getNumberOfUnpaidBills()
    {
        return DB::table('bills')
            ->where('status', 'unpaid')
            ->orWhere('status', 'sent')
            ->count();
    }

    private function getUnpaidBills()
    {
        return DB::table('bills')
            ->select('id', 'number', 'date', 'due_date', 'total', 'status')
            ->where('status', 'unpaid')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
    }

    private function getTopSellingProducts()
    {
        return DB::table('invoice_items')
            ->select('id', 'name', 'price', 'quantity')
            ->orderBy('quantity', 'desc')
            ->limit(5)
            ->get();
    }

    private function getNumberOfVendors()
    {
        return DB::table('vendors')->count();
    }

    private function getLowStockProducts()
    {
        return DB::table('products')
            ->select('id', 'name', 'stock', 'stock_min')
            ->where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
    }

    private function monthIncomeExpenseChar()
    {
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $char_data = [
            'labels' => [
                __('response.months.january'),
                __('response.months.february'),
                __('response.months.march'),
                __('response.months.april'),
                __('response.months.may'),
                __('response.months.june'),
                __('response.months.july'),
                __('response.months.august'),
                __('response.months.september'),
                __('response.months.october'),
                __('response.months.november'),
                __('response.months.december'),
            ],
            'datasets' => [
                [
                    'label' => __('response.dashboard.income'),
                    'data' => [],
                    'backgroundColor' => '#4caf50',
                ],
                [
                    'label' => __('response.dashboard.expense'),
                    'data' => [],
                    'backgroundColor' => '#f44336',
                ],
            ],
        ];
        foreach ($months as $value) {
            $income = DB::table('transactions')
                ->whereMonth('date', $value)
                ->where('type', 'income')
                ->sum('amount');

            $expense = DB::table('transactions')
                ->whereMonth('date', $value)
                ->where('type', 'expense')
                ->sum('amount');

            $char_data['datasets'][0]['data'][] = $income;
            $char_data['datasets'][1]['data'][] = $expense;
        }

        return $char_data;
    }

    private function currentMonthExpenseAndIncomeChar()
    {
        $month = date('m');

        $income = DB::table('transactions')
            ->whereMonth('date', $month)
            ->where('type', 'income')
            ->sum('amount');

        $expense = DB::table('transactions')
            ->whereMonth('date', $month)
            ->where('type', 'expense')
            ->sum('amount');

        $char_data = [
            'labels' => [__('response.dashboard.income'), __('response.dashboard.expense')],
            'datasets' => [
                [
                    'data' => [$income, $expense],
                    'backgroundColor' => ['#4caf50', '#f44336'],
                ],
            ],
        ];

        return $char_data;
    }

    public function getYearExpenseAndIncome()
    {
        $year = date('Y');
        $income = DB::table('transactions')
            ->whereYear('date', $year)
            ->where('type', 'income')
            ->sum('amount');

        $expense = DB::table('transactions')
            ->whereYear('date', $year)
            ->where('type', 'expense')
            ->sum('amount');

        return [
            'income' => $income,
            'expense' => $expense,
        ];
    }

    public function getDashboardData()
    {
        return [
            'products' => $this->getNumberOfProducts(),
            'vendors' => $this->getNumberOfVendors(),
            'unpaid_invoices' => $this->getNumberOfUnpaidInvoices(),
            'unpaid_invoices_list' => $this->getUnpaidInvoices(),
            'top_selling_products' => $this->getTopSellingProducts(),
            'low_stock_products' => $this->getLowStockProducts(),
            'customers' => $this->getNumberOfCustomers(),
            'unpaid_bills' => $this->getNumberOfUnpaidBills(),
            'unpaid_bills_list' => $this->getUnpaidBills(),
            'year_income_expense_char' => $this->monthIncomeExpenseChar(),
            'current_month_income_expense_char' => $this->currentMonthExpenseAndIncomeChar(),
            'year_income_expense' => $this->getYearExpenseAndIncome(),
        ];
    }
}
