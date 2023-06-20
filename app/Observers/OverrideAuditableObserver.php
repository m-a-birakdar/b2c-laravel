<?php

namespace App\Observers;

use OwenIt\Auditing\AuditableObserver;

class OverrideAuditableObserver extends AuditableObserver
{
    public function __construct()
    {
        config(['audit.drivers.database.connection' => tenant() ? tenant()->id . '-mongodb' : 'mongodb']);
    }
}
