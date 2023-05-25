<?php

namespace Modules\Coupon\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Modules\Coupon\Http\Requests\CuApi\V1\CouponRequest;
use Illuminate\Routing\Controller;
use Modules\Coupon\Interfaces\CuApi\V1\CouponRepositoryInterface;

class CouponController extends Controller
{
    public CouponRepositoryInterface $repository;

    public function __construct(CouponRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function check(CouponRequest $request): MainResource
    {
        return MainResource::make(null, true);
    }
}
