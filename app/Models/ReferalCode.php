<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferalCode extends Model
{
    protected $table = 'referal_codes';
    protected $fillable = [
        'code',
        'user_id',
        'referal_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
