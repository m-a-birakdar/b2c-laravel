<?php

namespace Modules\City\Enums;

enum StatusEnum: string
{
    case AVAILABLE = 'available';
    case Unavailable = 'unavailable';
    case SOON = 'soon';
}
