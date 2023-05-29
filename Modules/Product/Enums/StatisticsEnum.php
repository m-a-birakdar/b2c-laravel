<?php

namespace Modules\Product\Enums;

enum StatisticsEnum: int
{
    case Order          = 1;
    case View           = 2;
    case AddToCart      = 3;
    case RemoveFromCart = 4;
}
