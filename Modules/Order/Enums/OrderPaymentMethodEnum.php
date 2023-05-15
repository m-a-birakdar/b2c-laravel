<?php

namespace Modules\Order\Enums;

enum OrderPaymentMethodEnum: int
{
    case OnDoor = 1;
    case Wallet = 2;
//    case CreditCard = 3;
//    case BankTransfer = 4;
}
