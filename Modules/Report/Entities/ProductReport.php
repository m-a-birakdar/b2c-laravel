<?php

namespace Modules\Report\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ProductReport extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setConnection(tenant()->id . '-mongodb');
    }

    protected $collection = 'product_reports';

    public $timestamps = false;

    protected $fillable = ['type', 'day', 'month', 'year', 'products', 'created_at'];
}
