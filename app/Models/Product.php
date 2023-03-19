<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'sell_price',
        'buy_price',
        'stock',
        'stock_min',
        'stock_max',
        'unit',
        'active',
        'type',
        'barcode',
        'sku',
        'tax',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['stock_status'];

    protected $casts = [
        'active' => 'boolean',
        'buy_price' => 'float',
        'sell_price' => 'float',
        'stock' => 'float',
        'stock_min' => 'float',
        'stock_max' => 'float',
        'tax' => 'float',
        'unit' => 'string',
    ];

    public function generateTags(): array
    {
        return ['Product'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Function to return stock status
     *
     * @return string status (out_of_stock, in_stock, over_stock, low_stock, unknown, null )
     */
    public function getStockStatusAttribute()
    {
        if ($this->type == 'service' || $this->type == null) {
            return null;
        }

        if ($this->stock == null && $this->stock_min == null && $this->stock_max == null) {
            return null;
        }

        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock_max > $this->stock && $this->stock > $this->stock_min) {
            return 'in_stock';
        } elseif ($this->stock >= $this->stock_max) {
            return 'over_stock';
        } elseif ($this->stock <= $this->stock_min) {
            return 'low_stock';
        } else {
            return 'unknown';
        }
    }

    public function tax()
    {
        return DB::table('taxes')
            ->find($this->tax)
            ->get(['name', 'value', 'description', 'active']);
    }

    public function getProducts()
    {
        activity_log(user_data()->data->id, 'get products', null, 'App\Models\Product', 'getProducts');
        return $this->with(['category'])->get();
    }

    public function getProduct($id)
    {
        activity_log(user_data()->data->id, 'get product', $id, 'App\Models\Product', 'getProduct');
        return $this->with(['category'])->find($id);
    }

    public function createProduct($productData)
    {
        return $this->create($productData);
    }

    public function updateProduct($id, $productData)
    {
        $product = $this->find($id);
        if (!$product) {
            return false;
        }
        return $product->update($productData);
    }

    public function deleteProduct($id)
    {
        $product = $this->find($id);
        if (!$product) {
            return false;
        }
        return $product->delete();
    }
}
