<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletUserTransactions extends Model
{
    protected $table = 'wallet_transactions';

    protected $fillable = [
        'user_id',
        'amount',
        'transaction_id',
        'acount_number',
        'acount_name',
        'type',
    ];

    /**
     * Relationship: Transaction belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
