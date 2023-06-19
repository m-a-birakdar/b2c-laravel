<?php

namespace Modules\Shipment\Http\Controllers\CoApi\V1;

use Illuminate\Routing\Controller;
use Modules\Shipment\Interfaces\CoApi\V1\ShipmentRepositoryInterface;
use Modules\Shipment\Transformers\CoApi\V1\AllShipmentResource;
use Modules\Shipment\Transformers\CoApi\V1\ShipmentResource;

class ShipmentController extends Controller
{
    public ShipmentRepositoryInterface $repository;

    public function __construct(ShipmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($status): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return AllShipmentResource::collection($this->repository->index($status));
    }

    public function show($id)
    {
        return ShipmentResource::make($this->repository->show($id));
    }
}
