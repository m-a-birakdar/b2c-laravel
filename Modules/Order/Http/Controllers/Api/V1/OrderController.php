<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use Modules\Order\Http\Requests\Api\V1\OrderRequest;
use Illuminate\Routing\Controller;
use Modules\Order\Interfaces\Api\V1\OrderRepositoryInterface;
use Modules\Order\Transformers\Api\V1\OrderResource;

class OrderController extends Controller
{
    public OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(OrderRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(OrderRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
