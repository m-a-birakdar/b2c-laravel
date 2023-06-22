<?php

namespace Modules\Wallet\Entities;

use App\Models\OverrideModel;
use Modules\User\Entities\User;

/**
 * @property mixed $id
 * @property mixed $balance
 * @property mixed $number
 * @property mixed $allow_send
 * @property mixed $allow_receive
 */

class Wallet extends OverrideModel
{
    protected $fillable = ['user_id', 'balance', 'status', 'number', 'allow_send', 'allow_receive'];

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
