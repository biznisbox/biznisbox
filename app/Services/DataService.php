<?php

namespace App\Services;

use App\Models\Units;
use App\Models\Taxes;
use App\Models\Currencies;
use App\Models\Category;

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

    public function updateCategory($categoryData)
    {
        $category = new Category();
        $category = $category->updateCategory($categoryData->id, $categoryData);
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = new Category();
        $category = $category->getCategory($id);
        $category->deleteCategory();
        return $category;
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
            default:
                return null;
                break;
        }
    }
}
