<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'delivery_person_id',
        'quantity',
        'price',
        'p_price',
        'total_amount',
        'payment_status',
        'payment_method',
        'status',
        'delivery_address',
        'delivery_date',
        'notes',
        'orderid',
        'product_id',
        'shop',
        'longitude',
        'latitude',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function delivery()
    {
        return $this->hasOne(User::class, 'id', 'delivery_person_id');
    }
    public function productshop()
    {
        return $this->hasOne(Shops::class, 'id', 'shop');
    }

    public function productname()
    {
        return $this->belongsTo(Shops::class, 'id', 'shop');
    }
}
