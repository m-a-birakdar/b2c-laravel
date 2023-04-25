<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetails extends Model
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
