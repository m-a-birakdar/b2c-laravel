<?php

namespace Modules\Shipment\Interfaces\CuApi\V1;

interface ShipmentRepositoryInterface
{
    public function show($orderId);
}
