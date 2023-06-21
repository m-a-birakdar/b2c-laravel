<?php

namespace App\Models;

use App\Traits\OverrideAuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @method available()
 */

class OverrideModel extends Model implements Auditable
{
    use OverrideAuditableTrait, HybridRelations;
}
