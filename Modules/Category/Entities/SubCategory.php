<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = ['name', 'status', 'image', 'rank', 'parent_id'];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    protected static function newFactory(): \Modules\Category\Database\factories\CategoryFactory
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
    }
}
