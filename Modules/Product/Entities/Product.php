<?php

namespace Modules\Product\Entities;

use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;

class Product extends Model
{
    use HasFactory, ScopeModels;

    protected $fillable = ['city_id', 'category_id', 'title', 'sku', 'status', 'thumbnail', 'price', 'discount', 'rank'];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'double',
        'status' => 'bool',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $perPage = 25;

    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductDetails::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    protected static function newFactory(): \Modules\Product\Database\factories\ProductFactory
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
