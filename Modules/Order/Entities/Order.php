<?php

namespace Modules\Order\Entities;

use App\Models\OverrideModel;
use Modules\Address\Entities\Address;
use Modules\Order\Enums\OrderPaymentMethodEnum;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Product\Entities\Product;
use Modules\Shipment\Entities\Shipment;
use Modules\User\Entities\User;
use Modules\Wallet\Entities\Transaction;

/**
 * @property mixed $total_amount
 * @property mixed $shipping_amount
 * @property mixed $id
 */
class Order extends OverrideModel
{
    protected $fillable = [
        'sku', 'user_id', 'coupon_id', 'status', 'items_count', 'items_qty', 'shipping_amount', 'tax_amount', 'items_amount', 'discount_amount',
        'total_amount', 'address_id', 'payment_method', 'notify_review_at'
    ];

    protected $casts = [
        'shipping_amount' => 'double',
        'total_amount' => 'double',
        'items_amount' => 'double',
        'discount_amount' => 'double',
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

    public function getPaymentMethodHumanAttribute(): string
    {
        return match ($this->payment_method){
            OrderPaymentMethodEnum::OnDoor->value => 'OnDoor',
            OrderPaymentMethodEnum::Wallet->value => 'Wallet',
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

    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function shipment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function review(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderReview::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Transaction::class, 'sourceable');
    }
}
