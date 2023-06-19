<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

/**
 * @property mixed $id
 * @property mixed $balance
 * @property mixed $number
 */

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance', 'status', 'number'];

    protected $casts = [
        'balance' => 'double'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
