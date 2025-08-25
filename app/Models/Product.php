<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // optional if using default naming
    protected $fillable = [
        'name',
        'image',
        'product_category',
        'weight',
        'price',
        'p_price',
        'stock',
        'is_cylinder',
        'cylinder_type',
        'cylinder_material',
        'cylinder_capacity',
        'cylinder_pressure',
        'status',
        'shop',
        'description'
    ];

    public function productcategory()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category');
    }

    public function productshop()
    {
        return $this->hasOne(Shops::class, 'id', 'shop');
    }
}
