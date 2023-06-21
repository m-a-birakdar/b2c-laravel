<?php

namespace Modules\Currency\Entities;

use App\Models\OverrideModel;

class Currency extends OverrideModel
{
    protected $fillable = ['name', 'key', 'value'];

    protected $casts = [
        'value' => 'double'
    ];

    public $timestamps = false;
}
