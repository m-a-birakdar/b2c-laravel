<?php

namespace Modules\Whatsapp\Entities;

use App\Models\TenantModelMongo;
use Modules\Whatsapp\Enums\StatusEnum;
use MongoDB\BSON\UTCDateTime;

/**
 * @property mixed|UTCDateTime $created_at
 */

class Whatsapp extends TenantModelMongo
{
    protected $table = 'whatsapp';

    protected $fillable = [
        'priority', 'phone', 'message', 'media', 'send_at', 'status', 'message_id', 'created_at'
    ];

    protected static function boot()
    {
        parent::boot();
        parent::creating(function ($whatsapp) {
            $whatsapp->created_at = new UTCDateTime(time() * 1000);
            $whatsapp->status = StatusEnum::PENDING->value;
        });
    }
}
