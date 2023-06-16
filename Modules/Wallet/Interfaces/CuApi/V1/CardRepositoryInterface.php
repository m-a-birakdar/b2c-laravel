<?php

namespace Modules\Wallet\Interfaces\CuApi\V1;

interface CardRepositoryInterface
{
    public function recharge($request);
}
