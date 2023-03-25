<?php

namespace Modules\Tag\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Tag\Database\factories\TagFactory
    {
        return \Modules\Tag\Database\factories\TagFactory::new();
    }
}
