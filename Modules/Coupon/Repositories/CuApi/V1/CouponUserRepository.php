<?php

namespace Modules\Coupon\Repositories\CuApi\V1;

use Modules\Coupon\Entities\CouponUser;

class CouponUserRepository
{
    public CouponUser|null $model;

    public function __construct(CouponUser $model = new CouponUser())
    {
        $this->model = $model;
    }

    public function first($id): \Illuminate\Database\Eloquent\Builder|null
    {
        return $this->model = $this->model->query()->where('coupon_id', $id)->where('user_id', sanctum()->id)->first();
    }

    public function update($array)
    {
        return $this->model->update($array);
    }
}
