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

    protected $appends = ['key', 'label', 'children'];

    protected $hidden = ['name', 'description', 'module', 'parent_id', 'created_at', 'updated_at'];

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

    public function getKeyAttribute()
    {
        return $this->attributes['id'];
    }

    public function getLabelAttribute()
    {
        return $this->attributes['name'];
    }

    public function getChildrenAttribute()
    {
        return $this->children()->get();
    }

    public function createCategory($name, $module, $description = null, $color = null, $parent_id = null)
    {
        $category = $this->create([
            'name' => $name,
            'description' => $description,
            'color' => $color,
            'module' => $module,
            'parent_id' => $parent_id,
        ]);

        if ($category) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $data)
    {
        $category = $this->find($id);
        $category = $category->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'color' => $data['color'],
            'module' => $data['module'],
            'parent_id' => $data['parent_id'],
        ]);
        if ($category) {
            return true;
        }
        return false;
    }

    public function deleteCategory()
    {
        $this->delete();
    }

    public function getCategoriesByModule($module)
    {
        $categories = $this->where('module', $module)
            ->whereNull('parent_id')
            ->get();
        activity_log(user_data()->data->id, 'get categories by module', $module, 'App\Models\Category', 'getCategoriesByModule');
        return $categories;
    }
}
