<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'product_id',
        'qty',
        'p_price',
        'price',
        'user_id',
        'type',
        'shop',
        'weight',
        'remainqty',
    ];
}
