<?php

namespace Modules\Order\Entities;

use App\Models\OverrideModel;
use Modules\Product\Entities\Product;

class OrderItems extends OverrideModel
{
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'total_price', 'discount'];
    public $timestamps = false;

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
