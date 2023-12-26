<?php

namespace App\Services;

use App\Models\Units;
use App\Models\Taxes;
use App\Models\Currencies;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use App\Models\Employee;

class DataService
{
    public function __construct()
    {
        //
    }

    public function getUnits()
    {
        $units = new Units();
        $units = $units->getUnits();
        return $units;
    }

    public function getTaxes()
    {
        $taxes = new Taxes();
        $taxes = $taxes->getTaxes();
        return $taxes;
    }

    public function getCurrencies()
    {
        $currencies = new Currencies();
        $currencies = $currencies->getCurrencies();
        return $currencies;
    }

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

        $category = $category->createCategory($name, $module, $description, $color, $parent_id, $icon);
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

    public function getDepartments()
    {
        $departments = new Department();
        $departments = $departments->getPublicDepartments();
        return $departments;
    }

    public function getUsers()
    {
        $users = new User();
        $users = $users->getPublicUsers();
        return $users;
    }

    public function getEmployees()
    {
        $employees = new Employee();
        $employees = $employees->getPublicEmployees();
        return $employees;
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
            case 'currencies':
                return $this->getCurrencies();
                break;
            case 'departments':
                return $this->getDepartments();
                break;
            case 'users':
                return $this->getUsers();
                break;
            case 'employees':
                return $this->getEmployees();
                break;
            default:
                return null;
                break;
        }
    }
}
