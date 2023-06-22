<?php

namespace App\Models;

use App\Traits\OverrideAuditableTrait;
use Jenssegers\Mongodb\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TenantModelMongo extends Model implements Auditable
{
    use OverrideAuditableTrait;

    public function __construct()
    {
        parent::__construct();
        $this->setConnection(tenant() ? tenant()->id . '-mongodb' : 'mongodb');
    }

    public $timestamps = false;
}
