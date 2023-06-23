<?php

namespace Modules\Product\Entities;

use App\Models\OverrideModel;
use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Category\Entities\SubCategory;
use Modules\City\Entities\City;
use Modules\Order\Entities\Order;

/**
 * @property mixed $price
 * @property float|int|mixed $lira_price
 */

class Product extends OverrideModel
{
    use HasFactory, ScopeModels;

    protected $fillable = ['city_id', 'category_id', 'title', 'sku', 'status', 'thumbnail', 'price', 'discount', 'rank'];

    protected $casts = [
        'price' => 'double',
        'lira_price' => 'decimal:2',
        'discount' => 'double',
        'status' => 'bool',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $perPage = 25;

    protected static function booted()
    {
        static::creating(function ($user){
            $user->sku = Str::random();
        });
    }

    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductDetails::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'category_id');
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function statistics(): \Illuminate\Database\Eloquent\Relations\HasMany|\Jenssegers\Mongodb\Relations\HasMany
    {
        return $this->hasMany(ProductStatistics::class);
    }

    public function orders(): \Jenssegers\Mongodb\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }

    protected static function newFactory(): \Modules\Product\Database\factories\ProductFactory
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
