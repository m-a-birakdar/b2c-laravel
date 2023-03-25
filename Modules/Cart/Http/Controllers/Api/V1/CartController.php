<?php

namespace Modules\Cart\Http\Controllers\Api\V1;

use Modules\Cart\Http\Requests\Api\V1\CartRequest;
use Illuminate\Routing\Controller;
use Modules\Cart\Interfaces\Api\V1\CartRepositoryInterface;
use Modules\Cart\Transformers\Api\V1\CartResource;

class CartController extends Controller
{
    public CartRepositoryInterface $repository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(CartRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(CartRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
