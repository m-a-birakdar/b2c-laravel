<?php

namespace Modules\Report\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reports';

    protected $fillable = ['type', 'day', 'month', 'year', 'orders', 'categories', 'products', 'sub_categories', 'users', 'created_at'];
}
