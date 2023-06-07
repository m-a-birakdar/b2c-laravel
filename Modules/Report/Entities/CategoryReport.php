<?php

namespace Modules\Report\Entities;

use App\Models\TenantModelMongo;

class CategoryReport extends TenantModelMongo
{
    protected $collection = 'category_reports';

    protected $fillable = ['type', 'D', 'd', 'm', 'M', 'y', 'id', 'orders_count', 'products_count', 'created_at'];
}
