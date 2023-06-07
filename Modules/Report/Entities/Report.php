<?php

namespace Modules\Report\Entities;

use App\Models\TenantModelMongo;

class Report extends TenantModelMongo
{
    protected $collection = 'reports';

    public $timestamps = false;

    protected $fillable = ['type', 'D', 'd', 'm', 'M', 'y', 'orders', 'categories', 'products', 'sub_categories', 'users', 'created_at'];
}
