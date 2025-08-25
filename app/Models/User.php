<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'profile',
        'password',
        'phone_number',
        'cnic',
        'address_line_1',
        'address_line_2',
        'city',
        'province',
        'postal_code',
        'connection_type',
        'is_active',
        'role',
        'shop',
        'referal_code',
        'otp',
        'otp_expires_at',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'connection_start_date' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function shopname()
    {
        return $this->hasOne(Shops::class, 'id', 'shop');
    }
}
