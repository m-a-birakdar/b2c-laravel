<?php

namespace Modules\Notification\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';

    protected $fillable = ['user_id', 'title', 'body', 'type', 'initial', 'clicks', 'read_at'];
}
