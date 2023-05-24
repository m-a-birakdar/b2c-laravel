<?php

namespace Modules\User\Enums;

enum UserRolesEnum: string
{
    case MANAGER = 'manager';
    case ADMIN = 'admin';
    case COURIER = 'courier';
    case CUSTOMER = 'customer';
}
