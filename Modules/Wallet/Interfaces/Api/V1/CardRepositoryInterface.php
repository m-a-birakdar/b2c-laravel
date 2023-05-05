<?php

namespace Modules\Wallet\Interfaces\Api\V1;

interface CardRepositoryInterface
{
    public function get($number, $cvv);
}
