<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Product\Entities\Product;
use Modules\Shipment\Entities\Shipment;
use Modules\User\Entities\User;

class Order extends Model
{
    protected $fillable = ['sku', 'user_id', 'status', 'items_count', 'items_qty', 'shipping_amount', 'tax_amount', 'items_amount', 'discount_amount', 'total_amount'];

    protected $casts = [
        'shipping_amount' => 'double',
        'total_amount' => 'double',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusHumanAttribute(): string
    {
        return match ($this->status){
            OrderStatusEnum::Pending->value => 'Pending',
            OrderStatusEnum::Processing->value => 'Processing',
            OrderStatusEnum::Shipment->value => 'Shipped',
            OrderStatusEnum::Delivered->value => 'Delivered',
            OrderStatusEnum::Cancelled->value => 'Cancelled',
        };
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items')->using(OrderProduct::class)->withPivot([
            'quantity', 'price', 'total_price', 'discount',
        ]);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function shipment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
