<?php

namespace Modules\Order\Entities;

use App\Models\OverrideModel;

class OrderReview extends OverrideModel
{
    protected $table = 'order_reviews';

    protected $fillable = ['user_id', 'order_id', 'rating', 'comment', 'status'];
}
