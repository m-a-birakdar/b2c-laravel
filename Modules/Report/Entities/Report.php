<?php

namespace Modules\Report\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Report extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setConnection(tenant()->id . '-mongodb');
    }

    protected $collection = 'reports';

    public $timestamps = false;

    protected $fillable = ['type', 'day', 'month', 'year', 'orders', 'categories', 'products', 'sub_categories', 'users', 'created_at'];
}
