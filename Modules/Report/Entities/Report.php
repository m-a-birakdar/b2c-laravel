<?php

namespace Modules\Report\Entities;

use App\Models\TenantModelMongo;

class Report extends TenantModelMongo
{
    protected $collection = 'reports';

    public $timestamps = false;

    protected $fillable = ['type', 'D', 'd', 'm', 'M', 'Y', 'orders', 'categories', 'products', 'sub_categories', 'users'];
}
