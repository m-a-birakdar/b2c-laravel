<?php

namespace Modules\Report\Enums;

enum TypeEnum: string
{
    case DAILY = 'd';
    case WEEKLY = 'w';
    case MONTHLY = 'm';
    case YEARLY = 'y';
}
