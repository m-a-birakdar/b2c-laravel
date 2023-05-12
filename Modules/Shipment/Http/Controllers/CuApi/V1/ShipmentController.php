<?php

namespace Modules\Shipment\Http\Controllers\CuApi\V1;

use Illuminate\Routing\Controller;
use Modules\Shipment\Interfaces\CuApi\V1\ShipmentRepositoryInterface;
use Modules\Shipment\Transformers\CuApi\V1\ShipmentResource;

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
