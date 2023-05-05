<?php

namespace Modules\Wallet\Interfaces\Api\V1;

use Modules\Wallet\Entities\Card;

interface TransactionRepositoryInterface
{
    public function index();
    public function store($request);
}
