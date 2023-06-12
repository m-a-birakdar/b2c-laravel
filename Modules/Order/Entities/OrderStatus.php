<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'user_id', 'status',
    ];
}
