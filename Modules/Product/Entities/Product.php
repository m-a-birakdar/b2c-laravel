<?php

namespace Modules\Product\Entities;

use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, ScopeModels;

    protected $fillable = ['category_id', 'title', 'sku', 'status', 'thumbnail', 'price', 'discount'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $perPage = 25;

    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductDetails::class);
    }

    protected static function newFactory(): \Modules\Product\Database\factories\ProductFactory
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
