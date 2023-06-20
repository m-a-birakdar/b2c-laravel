<?php

namespace App\Traits;

use App\Observers\OverrideAuditableObserver;
use OwenIt\Auditing\Auditable;

trait OverrideAuditableTrait
{
    use Auditable;

    public static function bootAuditable(): void
    {
        if (static::isAuditingEnabled()) {
            static::observe(new OverrideAuditableObserver());
        }
    }
}
