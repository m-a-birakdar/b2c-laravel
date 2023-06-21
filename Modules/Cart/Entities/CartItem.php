<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $quantity
 */

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $fillable = ['cart_id', 'product_id', 'quantity'];
    public $timestamps = false;
}
