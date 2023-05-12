<?php

namespace Modules\Order\Interfaces\AdApi\V1;

interface OrderRepositoryInterface
{
    public function index($status);
    public function show($id);
    public function change($status);
}
