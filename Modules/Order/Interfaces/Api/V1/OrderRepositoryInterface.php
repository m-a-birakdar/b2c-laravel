<?php

namespace Modules\Order\Interfaces\Api\V1;

interface OrderRepositoryInterface
{
    public function save();
    public function index();
    public function show($orderId);
}
