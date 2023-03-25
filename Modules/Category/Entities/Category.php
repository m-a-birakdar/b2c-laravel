<?php

namespace Modules\Category\Entities;

use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class Category extends Model
{
    use HasFactory, ScopeModels;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = ['name', 'status', 'image', 'rank', 'parent_id'];

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubCategory::class, 'parent_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Product::class, SubCategory::class, 'parent_id', 'category_id');
    }

    protected static function newFactory(): \Modules\Category\Database\factories\CategoryFactory
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
    }
}
