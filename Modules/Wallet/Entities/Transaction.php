<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\User\Entities\User;

class Transaction extends Model
{
    protected $fillable = ['wallet_id', 'type', 'amount'];

    public function getSourceAttribute()
    {
        return match ($this->sourceable_type){
            Card::class => tr('card'),
            User::class => tr('user'),
            default => tr('default')
        };
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function sourceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function wallet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
