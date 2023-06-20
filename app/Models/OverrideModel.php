<?php

namespace App\Models;

use App\Traits\OverrideAuditableTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OverrideModel extends Model implements Auditable
{
    use OverrideAuditableTrait;
}
