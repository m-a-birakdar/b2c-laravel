<?php

namespace Modules\Support\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Support\Database\factories\SupportFactory
    {
        return \Modules\Support\Database\factories\SupportFactory::new();
    }
}
