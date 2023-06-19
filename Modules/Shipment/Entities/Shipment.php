<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Address\Entities\Address;
use Modules\Order\Entities\Order;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\User\Entities\User;
use Modules\Wallet\Entities\Transaction;

/**
 * @property mixed $created_at
 * @property mixed $status
 */

class Shipment extends Model
{
    protected $fillable = ['track_number', 'customer_id', 'courier_id', 'status', 'address_id', 'order_id'];

    public function getStatusHumanAttribute(): string
    {
        return match ($this->status){
            ShipmentStatusEnum::NotYetShipped->value    => tr('not_yet_shipped'),
            ShipmentStatusEnum::InTransit->value        => tr('in_transit'),
            ShipmentStatusEnum::OutForDelivery->value   => tr('out_for_delivery'),
            ShipmentStatusEnum::Delivered->value        => tr('delivered'),
            ShipmentStatusEnum::FailedDelivery->value   => tr('failed_delivery'),
            ShipmentStatusEnum::ReturnInProgress->value => tr('return_in_progress'),
        };
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function courier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Transaction::class, 'sourceable');
    }
}
