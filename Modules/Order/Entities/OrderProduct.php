<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $casts = [
        'total_price' => 'double',
        'price' => 'double',
        'discount' => 'double',
    ];
}
