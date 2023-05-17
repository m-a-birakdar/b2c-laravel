<?php

namespace Modules\Order\Interfaces\CoApi\V1;

interface OrderRepositoryInterface
{
    public function show($id);
    public function toDelivered($id);
}
