<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockPurchase extends Model
{
    protected $table = 'stock_purchases';
    protected $fillable = [
        'product_id',
        'qty',
        'price',
        'p_price',
        'user_id',
        'shop',
        'weight',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public function productshop()
    {
        return $this->hasOne(Shops::class, 'id', 'shop');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
