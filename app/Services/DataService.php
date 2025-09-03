<?php

namespace App\Services;

use App\Mail\User\PersonalAccessTokenCreated;
use App\Models\ActivityLog;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Category;
use App\Utils\JwtBlackList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
    public function getCategories($module, $list = false)
    {
        $categories = new Category();
        $categories = $categories->getCategoriesByModule($module, $list);
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

    /****************************************
     * Personal Access Token services
     ****************************************/

    public function getPersonalAccessTokens()
    {
        $personalAccessToken = new \App\Models\PersonalAccessToken();
        $userId = auth()->id();
        $personalAccessToken = $personalAccessToken->getPersonalAccessTokens($userId);
        return $personalAccessToken;
    }

    public function getPersonalAccessToken($id)
    {
        $personalAccessToken = new \App\Models\PersonalAccessToken();
        $personalAccessToken = $personalAccessToken->getPersonalAccessToken($id);

        if ($personalAccessToken->user_id != auth()->id()) {
            return null;
        }

        return $personalAccessToken;
    }

    public function createPersonalAccessToken($data)
    {
        $personalAccessToken = new \App\Models\PersonalAccessToken();
        $data['user_id'] = auth()->id();
        $data['name'] = $data['name'] ?? 'Personal Access Token';

        $user = new \App\Models\User();
        $user = $user->find($data['user_id']);

        $ttl = $data['valid_until'] ?? 'one_day';

        $ttls = [
            'one_day' => 1440,
            'one_week' => 10080,
            'one_month' => 43200,
            'one_year' => 525600,
            'never' => 525600 * 50, // 50 years (mysql cant insert 100 years :( ) -> 525600 minutes in a year
            'one_hour' => 60,
            'six_months' => 262800,
            'custom' => $data['valid_until'],
        ];

        $token = auth()
            ->setTTL($ttls[$ttl])
            ->claims(['personal_access_token' => true])
            ->login($user);

        $data['type'] = 'personal_access_token';
        $data['valid_until'] = now()->addMinutes($ttls[$ttl])->toDateTimeString();

        $data['token'] = getJwtPayloadData($token)['jti'];

        $personalAccessToken = $personalAccessToken->create($data);

        setEmailConfig();
        Mail::to($user->email, $user->first_name . ' ' . $user->last_name)->queue(
            new PersonalAccessTokenCreated($user, $personalAccessToken),
        );
        return $token;
    }

    /**
     * Delete personal access token
     */
    public function deletePersonalAccessToken($id)
    {
        $personalAccessToken = new \App\Models\PersonalAccessToken();

        $personalAccessToken = $personalAccessToken
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if (!$personalAccessToken) {
            return null;
        }

        // Revoke the token
        DB::table(JwtBlackList::TABLE_NAME)->insert([
            'id' => Str::orderedUuid(),
            'key' => $personalAccessToken->token,
            'valid_until' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalAccessToken = $personalAccessToken->delete($id);
        return $personalAccessToken;
    }
}
