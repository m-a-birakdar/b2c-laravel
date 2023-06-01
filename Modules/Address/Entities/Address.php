<?php

namespace Modules\Address\Entities;

use App\Models\OverrideModel;
use Modules\City\Entities\City;
use Modules\User\Entities\User;

class Address extends OverrideModel
{
    protected $fillable = ['user_id', 'city_id', 'address'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
