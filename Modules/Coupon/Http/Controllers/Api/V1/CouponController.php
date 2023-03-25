<?php

namespace Modules\Coupon\Http\Controllers\Api\V1;

use Modules\Coupon\Http\Requests\Api\V1\CouponRequest;
use Illuminate\Routing\Controller;
use Modules\Coupon\Interfaces\Api\V1\CouponRepositoryInterface;
use Modules\Coupon\Transformers\Api\V1\CouponResource;

class CouponController extends Controller
{
    public CouponRepositoryInterface $repository;

    public function __construct(CouponRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(CouponRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(CouponRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
