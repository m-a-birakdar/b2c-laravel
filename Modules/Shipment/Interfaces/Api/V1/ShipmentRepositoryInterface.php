<?php

namespace Modules\Shipment\Interfaces\Api\V1;

interface ShipmentRepositoryInterface
{
    public function show($orderId);
}
