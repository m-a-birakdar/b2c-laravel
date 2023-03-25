<?php

namespace App\Traits;

use App\Enums\StatusEnum;

trait ScopeModels
{
    public function scopeAvailable($q)
    {
        return $q->where('status', StatusEnum::Available);
    }

    public function scopeUnavailable($q)
    {
        return $q->where('status', StatusEnum::Unavailable);
    }
}
