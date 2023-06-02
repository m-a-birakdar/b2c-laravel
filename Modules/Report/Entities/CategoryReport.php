<?php

namespace Modules\Report\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class CategoryReport extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setConnection(tenant()->id . '-mongodb');
    }

    protected $collection = 'category_reports';

    public $timestamps = false;

    protected $fillable = ['type', 'day', 'month', 'year', 'categories', 'created_at'];
}
