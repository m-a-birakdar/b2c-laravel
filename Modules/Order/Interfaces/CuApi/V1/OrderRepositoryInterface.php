<?php

namespace Modules\Order\Interfaces\CuApi\V1;

use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;

interface OrderRepositoryInterface
{
    public function save(OrderRequest $request);
    public function review($array);
    public function index();
    public function show($orderId);
}
