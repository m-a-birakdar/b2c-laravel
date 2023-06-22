<?php

namespace Modules\Cart\Entities;

use App\Models\OverrideModel;

/**
 * @property mixed $quantity
 */

class CartItem extends OverrideModel
{
    protected $table = 'cart_items';
    protected $fillable = ['cart_id', 'product_id', 'quantity'];
    public $timestamps = false;
}
