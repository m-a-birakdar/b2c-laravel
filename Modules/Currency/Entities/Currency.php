<?php

namespace Modules\Currency\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'key', 'value'];

    protected $casts = [
        'value' => 'double'
    ];

    public $timestamps = false;
}
