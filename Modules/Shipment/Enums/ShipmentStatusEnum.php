<?php

namespace Modules\Shipment\Enums;

enum ShipmentStatusEnum: int
{
    case NotYetShipped = 1;
    case InTransit = 2;
    case OutForDelivery = 3;
    case Delivered = 4;
//    case FailedDelivery = 5;
//    case ReturnInProgress = 6;
}
