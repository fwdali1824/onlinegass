<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsUsers extends Model
{
    protected $table = 'notifications_users';

    protected $fillable = [
        'from_user',
        'to_user',
        'notification_id',
        'read_at',
    ];

    public function notification()
    {
        return $this->belongsTo(Notifications::class, 'notification_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'to_user', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user', 'id');
    }
}
