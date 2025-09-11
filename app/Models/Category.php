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

    public static $modelName = 'App\Models\Category';

    protected $table = 'categories';

    protected $fillable = ['name', 'description', 'color', 'module', 'parent_id', 'icon', 'additional_info'];

    protected $appends = ['key', 'label', 'children'];

    protected $hidden = ['created_at', 'updated_at'];

    public function generateTags(): array
    {
        return ['Category'];
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
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

    /**
     * Create new category
     * @param string $name Name of the category (it will be used as a label)
     * @param string $module Module of the category (in which module it will be used - ex. 'archive')
     * @param string $description Description of the category
     * @param string $color Color of the category (hexadecimal)
     * @param string $parent_id Parent category id
     * @param string $icon Icon of the category (ex. 'fa fa-folder')
     * @param string $additional_info Additional info of the category (ex. 'transfer')
     * @return boolean True if category is created, false if not
     */
    public function createCategory(
        $name,
        $module,
        $description = null,
        $color = null,
        $parent_id = null,
        $icon = null,
        $additional_info = null,
    ) {
        $category = $this->create([
            'name' => $name,
            'description' => $description,
            'color' => $color,
            'module' => $module,
            'icon' => $icon,
            'parent_id' => $parent_id,
            'additional_info' => $additional_info,
        ]);

        if ($category) {
            return $category;
        }
        return false;
    }

    /**
     * Update category
     * @param UUID $id Category UUID
     * @param mixed $data Data to update (ex. ['name' => 'New name']) if some data is not provided it will not be updated (it will stay the same)
     * @return boolean True if category is updated, false if not
     */
    public function updateCategory($id, $data)
    {
        $category = $this->find($id);
        $category = $category->update([
            'name' => $data['name'] ?? $category->name,
            'description' => $data['description'] ?? $category->description,
            'color' => $data['color'] ?? $category->color,
            'module' => $data['module'] ?? $category->module,
            'parent_id' => $data['parent_id'] ?? $category->parent_id,
            'icon' => $data['icon'] ?? $category->icon,
            'additional_info' => $data['additional_info'] ?? $category->additional_info,
        ]);
        if ($category) {
            return true;
        }
        return false;
    }

    /**
     * Delete category
     * @param UUID $id Category id
     * @return boolean True if category is deleted, false if not
     */
    public function deleteCategory($id)
    {
        return $this->where('id', $id)->delete();
    }

    /**
     * Get category by module
     * @param string $module Module of the category (in which module it will be used - ex. 'archive')
     * @param boolean $showAll Used for indicate for show all ungrouped
     * @return object Category object
     */
    public static function getCategoriesByModule($module, $showAll = false)
    {
        if ($showAll == 'true') {
            $categories = self::where('module', $module)->get();
        } else {
            $categories = self::with('children')->where('module', $module)->whereNull('parent_id')->get();
        }

        createActivityLog('retrieve', null, Category::$modelName, 'Category');
        return $categories;
    }

    /**
     * Get category by id
     * @param UUID $id Category id
     * @return object Category object
     */
    public function getCategory($id)
    {
        $category = $this->where('id', $id)->first();
        if ($category) {
            createActivityLog('retrieve', $id, Category::$modelName, 'Category');
            return $category;
        }
        return false;
    }
}
