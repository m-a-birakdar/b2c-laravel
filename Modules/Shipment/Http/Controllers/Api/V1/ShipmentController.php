<?php

namespace Modules\Shipment\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Modules\Shipment\Interfaces\Api\V1\ShipmentRepositoryInterface;
use Modules\Shipment\Transformers\Api\V1\ShipmentResource;

class ShipmentController extends Controller
{
    public ShipmentRepositoryInterface $repository;

    public function __construct(ShipmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show($orderId): ShipmentResource
    {
        return ShipmentResource::make($this->repository->show($orderId));
    }
}
