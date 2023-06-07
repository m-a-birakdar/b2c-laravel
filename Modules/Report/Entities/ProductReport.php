<?php

namespace Modules\Report\Entities;

use App\Models\TenantModelMongo;

class ProductReport extends TenantModelMongo
{
    protected $collection = 'product_reports';

    protected $fillable = ['type', 'D', 'd', 'm', 'M', 'y', 'id', 'orders_count', 'created_at', 'st_orders', 'st_views', 'st_add_cart', 'st_remove_cart', 'st_add_favorite', 'st_remove_favorite', ];
}
