<?php

namespace Modules\Whatsapp\Entities;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $table = 'whatsapp';

    protected $fillable = [
        'type', 'priority', 'phone', 'message', 'media', 'send_at', 'status'
    ];
}
