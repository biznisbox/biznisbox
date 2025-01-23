<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataService
{
    public function getTaxes()
    {
        return Tax::all()->where('active', true);
    }

    public function getUnits()
    {
        return Unit::all()->where('active', true);
    }

    public function getPublicEmployees()
    {
        $employees = new \App\Models\Employee();
        $employees = $employees->getPublicEmployees();
        return $employees;
    }

    public function getPublicUsers()
    {
        $users = new \App\Models\User();
        $users = $users->getPublicUsers();
        return $users;
    }

    public function getDepartments()
    {
        $departments = new \App\Models\Department();
        $departments = $departments->getPublicDepartments();
        return $departments;
    }

    public function getProducts()
    {
        $products = new \App\Models\Product();
        $products = $products->getPublicProducts();
        return $products;
    }

    public function getAvailableLocales()
    {
        $locales = config('app.available_locales');
        return $locales;
    }

    public function getLogs($item_id, $item_type)
    {
        if (!$item_id || !$item_type) {
            return null;
        }

        $logs = ActivityLog::where([
            'auditable_type' => 'App\Models\\' . $item_type,
            'auditable_id' => $item_id,
        ])
            ->with('user:id,first_name,last_name,picture,email', 'externalKeyData')
            ->orderBy('id', 'desc')
            ->get();

        return $logs;
    }

    public function getCurrencies()
    {
        $currencies = new \App\Models\Currency();
        $currencies = $currencies
            ->where('status', 'active')
            ->get([
                'id',
                'name',
                'code',
                'symbol',
                'exchange_rate',
                'status',
                'decimal_separator',
                'thousand_separator',
                'number_of_decimal',
                'placement',
            ]);
        return $currencies;
    }

    /****************************************
     * Category services
     ****************************************/
    public function getCategories($module)
    {
        $categories = new Category();
        $categories = $categories->getCategoriesByModule($module);
        return $categories;
    }

    public function getCategory($id)
    {
        $category = new Category();
        $category = $category->getCategory($id);
        return $category;
    }

    public function createCategory($categoryData)
    {
        $category = new Category();
        $name = $categoryData['name'] ?? null;
        $module = $categoryData['module'] ?? null;
        $description = $categoryData['description'] ?? null;
        $color = $categoryData['color'] ?? null;
        $parent_id = $categoryData['parent_id'] ?? null;
        $icon = $categoryData['icon'] ?? null;
        $additional_info = $categoryData['additional_info'] ?? null;

        $category = $category->createCategory($name, $module, $description, $color, $parent_id, $icon, $additional_info);
        return $category;
    }

    public function updateCategory($id, $categoryData)
    {
        $category = new Category();
        $category = $category->updateCategory($id, $categoryData);
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = new Category();
        $category = $category->deleteCategory($id);
        return $category;
    }

    /****************************************
     * Dashboard related functions
     ****************************************/
    public function getDashboardLayout($type = 'user')
    {
        $dashboard_layout = DB::table('dashboard')
            ->where([
                'user_id' => auth()->id(),
                'type' => $type,
            ])
            ->first();

        if (!$dashboard_layout) {
            $dashboard_layout = DB::table('dashboard')->insert([
                'id' => Str::uuid(),
                'user_id' => auth()->id(),
                'content' => '[]',
                'created_at' => now(),
                'updated_at' => now(),
                'type' => $type,
            ]);
            $dashboard_layout = DB::table('dashboard')
                ->where([
                    'user_id' => auth()->id(),
                    'type' => $type,
                ])
                ->first();
        }
        return $dashboard_layout;
    }

    public function updateDashboardLayout($data, $type = 'user')
    {
        $dashboard_layout = DB::table('dashboard')
            ->where([
                'user_id' => auth()->id(),
                'type' => $type,
            ])
            ->update([
                'content' => $data,
                'updated_at' => now(),
            ]);
        return $dashboard_layout;
    }

    public function createWebhookSubscription($data)
    {
        $webhook = new \App\Models\WebhookSubscription();
        $data['headers'] = $this->formatHeaderForBackend($data['headers']);
        $data['user_id'] = auth()->id();
        $webhook = $webhook->create($data);
        return $webhook;
    }

    public function deleteWebhookSubscription($id)
    {
        $webhook = new \App\Models\WebhookSubscription();

        $webhook = $webhook
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if (!$webhook) {
            return null;
        }
        $webhook = $webhook->delete($id);
        return $webhook;
    }

    public function returnData($requiredData)
    {
        switch ($requiredData) {
            case 'units':
                return $this->getUnits();
                break;
            case 'taxes':
                return $this->getTaxes();
                break;
            case 'employees':
                return $this->getPublicEmployees();
                break;
            case 'users':
                return $this->getPublicUsers();
                break;
            case 'departments':
                return $this->getDepartments();
                break;
            case 'products':
                return $this->getProducts();
                break;
            case 'locales':
                return $this->getAvailableLocales();
                break;
            default:
                return null;
                break;
        }
    }

    private function formatHeaderForBackend($header)
    {
        $formattedHeader = [];
        foreach ($header as $h) {
            $formattedHeader[$h['key']] = $h['value'];
        }
        return $formattedHeader;
    }
}
