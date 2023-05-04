<?php

namespace Modules\Address\Entities;

use App\OverrideModel;
use Modules\User\Entities\User;

class Address extends OverrideModel
{
    protected $fillable = ['user_id', 'city', 'address'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
