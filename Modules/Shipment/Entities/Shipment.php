<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Address\Entities\Address;
use Modules\Order\Entities\Order;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\User\Entities\User;

class Shipment extends Model
{
    protected $fillable = ['track_number', 'user_id', 'status', 'address_id', 'order_id'];

    public function getStatusHumanAttribute(): string
    {
        return match ($this->status){
            ShipmentStatusEnum::NotYetShipped->value => 'NotYetShipped',
            ShipmentStatusEnum::InTransit->value => 'InTransit',
            ShipmentStatusEnum::OutForDelivery->value => 'OutForDelivery',
            ShipmentStatusEnum::Delivered->value => 'Delivered',
            ShipmentStatusEnum::FailedDelivery->value => 'FailedDelivery',
            ShipmentStatusEnum::ReturnInProgress->value => 'ReturnInProgress',
        };
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
