<?php

namespace Modules\Advertise\Http\Controllers\Api\V1;

use Modules\Advertise\Http\Requests\Api\V1\AdvertiseRequest;
use Illuminate\Routing\Controller;
use Modules\Advertise\Interfaces\Api\V1\AdvertiseRepositoryInterface;
use Modules\Advertise\Transformers\Api\V1\AdvertiseResource;

class AdvertiseController extends Controller
{
    public AdvertiseRepositoryInterface $repository;

    public function __construct(AdvertiseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(AdvertiseRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(AdvertiseRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
