<?php

namespace App\Models;

use App\Traits\OverrideAuditableTrait;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @method mixed available()
 * @property mixed $status
 * @property mixed $user_id
 * @method create(array $array)
 * @method increment(string $column)
 * @method decrement(string $column)
 */

class OverrideModel extends Model implements Auditable
{
    use OverrideAuditableTrait, HybridRelations;
}
