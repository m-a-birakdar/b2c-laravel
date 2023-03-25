<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Notification\Database\factories\NotificationFactory
    {
        return \Modules\Notification\Database\factories\NotificationFactory::new();
    }
}
