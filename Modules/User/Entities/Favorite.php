<?php

namespace Modules\User\Entities;

use App\Models\TenantModelMongo;

class Favorite extends TenantModelMongo
{
    protected $collection = 'favorites';

    protected $fillable = [
        'product_ids', 'user_id', 'created_at'
    ];
}
