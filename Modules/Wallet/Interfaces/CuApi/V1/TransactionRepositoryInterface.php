<?php

namespace Modules\Wallet\Interfaces\CuApi\V1;

interface TransactionRepositoryInterface
{
    public function index();
    public function store($request);
}
