<?php

namespace Modules\Product\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ProductStatistics extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'product_statistics';

    protected $fillable = [
        'product_id', 'type'
    ];
}
