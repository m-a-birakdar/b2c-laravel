<?php

namespace Modules\Notification\Entities;

use App\Models\TenantModelMongo;
use App\Traits\OverrideAuditableTrait;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Notification extends TenantModelMongo
{
    // Todo
//    use OverrideAuditableTrait, HybridRelations;

    public $timestamps = true;

    protected $collection = 'notifications';

    protected $fillable = ['user_id', 'title', 'body', 'type', 'initial', 'clicks', 'read_at'];
}
