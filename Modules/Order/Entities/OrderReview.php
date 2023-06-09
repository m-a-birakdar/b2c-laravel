<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    protected $table = 'order_reviews';

    protected $fillable = ['user_id', 'order_id', 'rating', 'comment', 'status'];
}
