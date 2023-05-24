<?php

namespace Modules\Notification\Enums;

enum NotificationTypeEnum: int
{
    case ORDER  = 1;
    case COUPON = 2;
    case OFFER  = 3;
    case NEWS   = 4;
}
