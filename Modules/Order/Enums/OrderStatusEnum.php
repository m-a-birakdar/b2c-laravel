<?php

namespace Modules\Order\Enums;

enum OrderStatusEnum: int
{
    case Cancelled  = 0;
    case Pending    = 1;
    case Processing = 2;
    case Shipment   = 3;
    case Delivered  = 4;
}
