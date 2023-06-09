<?php

namespace Modules\User\Entities;

use App\Models\TenantModelMongo;

class Search extends TenantModelMongo
{
    protected $collection = 'search';

    protected $fillable = [
        'text', 'user_id', 'created_at'
    ];
}

