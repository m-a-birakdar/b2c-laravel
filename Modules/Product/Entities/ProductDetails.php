<?php

namespace Modules\Product\Entities;

use App\Models\OverrideModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetails extends OverrideModel
{
    use HasFactory;

    protected $table = 'product_details';

    protected $fillable = ['product_id', 'description', 'quantity'];

    public $timestamps = false;

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory(): \Modules\Product\Database\factories\ProductDetailsFactory
    {
        return \Modules\Product\Database\factories\ProductDetailsFactory::new();
    }
}
