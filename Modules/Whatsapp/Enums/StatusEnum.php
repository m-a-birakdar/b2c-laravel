<?php

namespace Modules\Whatsapp\Enums;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FIELD = 'field';
}
