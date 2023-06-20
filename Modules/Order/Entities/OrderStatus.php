<?php

namespace Modules\Order\Entities;

use App\Models\OverrideModel;

class OrderStatus extends OverrideModel
{
    protected $table = 'order_status';
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'user_id', 'status',
    ];
}
