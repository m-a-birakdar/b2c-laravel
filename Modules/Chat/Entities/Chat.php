<?php

namespace Modules\Chat\Entities;

use App\Models\TenantModelMongo;

class Chat extends TenantModelMongo
{
    protected $table = 'chat_messages';
}
