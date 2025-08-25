<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{

    protected $table = 'notifications';

    protected $fillable = [
        'message',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'notifications_users', 'notification_id', 'user_id');
    }
}
