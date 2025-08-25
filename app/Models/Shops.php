<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    protected $table = 'shops';
    protected $fillable = [
        'name',
        'address',
        'lat',
        'long',
        'phone',
        'time',
        'today_rate',
        'whatsapp',
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'shop', 'id');
    }
    // App\Models\Shops.php

    public function products()
    {
        return $this->hasMany(Product::class, 'shop','id'); // Adjust key if needed
    }
}
