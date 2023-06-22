<?php

namespace Modules\Wallet\Interfaces\CuApi\V1;

use Modules\Wallet\Http\Requests\CuApi\V1\SendRequest;

interface WalletRepositoryInterface
{
    public function show();
    public function send(SendRequest $array);
}
