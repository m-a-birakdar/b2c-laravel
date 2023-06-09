<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

/**
 * @property mixed $shipping_amount
 * @property mixed $items_qty
 * @property mixed $items_count
 */
class Cart extends Model
{
    protected $fillable = ['user_id', 'items_count', 'items_qty', 'shipping_amount', 'items_amount', 'notify_at'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_items')->withPivot('quantity');
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
