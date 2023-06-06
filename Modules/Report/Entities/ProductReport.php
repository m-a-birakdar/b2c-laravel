<?php

namespace Modules\Report\Entities;

use App\Models\TenantModelMongo;

class ProductReport extends TenantModelMongo
{
    protected $collection = 'product_reports';

    protected $fillable = ['type', 'D', 'd', 'm', 'M', 'Y', 'products'];
}
