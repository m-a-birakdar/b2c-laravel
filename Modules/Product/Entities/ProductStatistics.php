<?php

namespace Modules\Product\Entities;

use App\Models\TenantModelMongo;

class ProductStatistics extends TenantModelMongo
{
    public $timestamps = false;

    protected $collection = 'product_statistics';

    protected $fillable = [
        'product_id', 'user_id', 'type', 'created_at'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\Jenssegers\Mongodb\Relations\BelongsTo
    {
        return $this->setConnection('tenant')->belongsTo(Product::class);
    }
}
