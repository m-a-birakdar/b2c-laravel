<?php

namespace Modules\Shipment\Http\Controllers\Api\V1;

use Modules\Shipment\Http\Requests\Api\V1\ShipmentRequest;
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

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(ShipmentRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(ShipmentRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
