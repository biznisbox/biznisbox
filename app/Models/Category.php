<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'categories';

    protected $fillable = ['name', 'description', 'color', 'module', 'parent_id'];

    public function generateTags(): array
    {
        return ['Category'];
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function newCategory($data)
    {
        $category = $this->create($data);

        if ($category) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $data)
    {
        $category = $this->find($id);
        $category = $category->update($data);
        if ($category) {
            return true;
        }
        return false;
    }

    public function deleteCategory()
    {
        $this->delete();
    }

    public function getCategories()
    {
        $categories = $this->all();
        activity_log(user_data()->data->id, 'get categories', null, 'App\Models\Category', 'getCategories');
        return $categories;
    }

    public function getCategory($id)
    {
        $category = $this->find($id);
        activity_log(user_data()->data->id, 'get category', $id, 'App\Models\Category', 'getCategory');
        return $category;
    }

    public function getCategoriesByModule($module)
    {
        $categories = $this->where('module', $module)->get();
        activity_log(user_data()->data->id, 'get categories by module', $module, 'App\Models\Category', 'getCategoriesByModule');
        return $categories;
    }

    public function getCategoryArray($module)
    {
        $categories = $this->whereNull('parent_id')
            ->where('module', $module)
            ->with('children')
            ->get();
        activity_log(user_data()->data->id, 'get category array', $module, 'App\Models\Category', 'getCategoryArray');
        return $categories;
    }
}
