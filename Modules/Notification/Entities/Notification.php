<?php

namespace Modules\Notification\Entities;

use App\Models\TenantModelMongo;

class Notification extends TenantModelMongo
{
    public $timestamps = true;

    protected $collection = 'notifications';

    protected $fillable = ['user_id', 'title', 'body', 'type', 'initial', 'clicks', 'read_at'];
}
