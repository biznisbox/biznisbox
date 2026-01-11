<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Product';

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'number',
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
        'tax',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['stock_status', 'plain_text'];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'buy_price' => 'double',
            'sell_price' => 'double',
            'stock' => 'double',
            'stock_min' => 'double',
            'stock_max' => 'double',
            'tax' => 'double',
        ];
    }

    public function generateTags(): array
    {
        return ['Product'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Function to get plain text description - remove html tags
     * @return string description Return plain text description
     */
    public function getPlainTextAttribute()
    {
        return strip_tags($this->description);
    }

    /**
     * Function to return stock status
     * @return string status Return status of stock (out_of_stock, in_stock, over_stock, low_stock, unknown, null)
     */
    public function getStockStatusAttribute()
    {
        // if product is service or type is null
        if ($this->type == 'service' || $this->type == null) {
            return null;
        }
        // if stock, stock_min and stock_max are null or 0
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

    /**
     * Function to get product number
     * @return void Return product number
     */
    public static function getProductNumber()
    {
        return generateNextNumber(settings('product_number_format'), 'product');
    }

    /**
     * Function for get public products
     * @return void Return public products
     */
    public static function getPublicProducts()
    {
        $products = self::where('active', true)->get([
            'id',
            'number',
            'name',
            'description',
            'sell_price',
            'buy_price',
            'stock',
            'stock_min',
            'stock_max',
            'unit',
            'active',
            'type',
            'barcode',
            'tax',
        ]);
        createActivityLog('retrievePublic', null, Product::$modelName, 'Product');
        return $products;
    }
}
