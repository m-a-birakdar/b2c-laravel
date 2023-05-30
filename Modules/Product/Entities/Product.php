<?php

namespace Modules\Product\Entities;

use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Modules\Category\Entities\SubCategory;
use Modules\City\Entities\City;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory, ScopeModels, AuditableTrait, HybridRelations;

    protected $fillable = ['city_id', 'category_id', 'title', 'sku', 'status', 'thumbnail', 'price', 'discount', 'rank'];

    protected $casts = [
        'price' => 'decimal:2',
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

    protected static function newFactory(): \Modules\Product\Database\factories\ProductFactory
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
