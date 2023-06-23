<?php

namespace Modules\Wallet\Entities;

use App\Models\OverrideModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Order\Entities\Order;
use Modules\Shipment\Entities\Shipment;
use Modules\User\Entities\User;

/**
 * @property mixed $created_at
 * @property mixed $sourceable_type
 */

class Transaction extends OverrideModel
{
    protected $fillable = ['wallet_id', 'type', 'amount'];

    protected $casts = [
        'amount' => 'float'
    ];

    public function getSourceAttribute()
    {
        return match ($this->sourceable_type){
            Card::class => tr('card'),
            Order::class => tr('order'),
            Shipment::class => tr('shipment'),
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
