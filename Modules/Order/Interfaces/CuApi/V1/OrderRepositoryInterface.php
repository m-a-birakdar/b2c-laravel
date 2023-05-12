<?php

namespace Modules\Order\Interfaces\CuApi\V1;

interface OrderRepositoryInterface
{
    public function save();
    public function index();
    public function show($orderId);
}
