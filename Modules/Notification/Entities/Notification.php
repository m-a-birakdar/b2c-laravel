<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['user_id', 'title', 'body', 'type', 'initial', 'clicks', 'read_at'];
}
