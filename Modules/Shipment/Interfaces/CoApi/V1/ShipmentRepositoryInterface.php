<?php

namespace Modules\Shipment\Interfaces\CoApi\V1;

interface ShipmentRepositoryInterface
{
    public function index($status);
    public function show($id);
}
