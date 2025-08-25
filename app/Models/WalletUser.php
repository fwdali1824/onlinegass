<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletUser extends Model
{
    protected $table = 'wallet_users';

    protected $fillable = [
        'user_id',
        'balance',
        'last_transaction',
    ];

    /**
     * Relationship: Wallet belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
