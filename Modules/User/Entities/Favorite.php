<?php

namespace Modules\User\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Favorite extends Model
{
    protected $connection = 'mongodb';

    public $timestamps = false;

    protected $collection = 'favorites';

    protected $fillable = [
        'product_ids', 'user_id', 'created_at'
    ];
}
