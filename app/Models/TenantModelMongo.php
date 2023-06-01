<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TenantModelMongo extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setConnection(tenant()->id . '-mongodb');
    }

    public $timestamps = false;

}
