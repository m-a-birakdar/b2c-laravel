<?php

namespace Modules\Coupon\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\CouponUser;
use Modules\Coupon\Interfaces\CuApi\V1\CouponRepositoryInterface;
use Modules\Coupon\Entities\Coupon;

class CouponRepository implements CouponRepositoryInterface
{
    use BaseRepositoryTrait;

    public Coupon|null $model;

    public function __construct(Coupon $model = new Coupon())
    {
        $this->model = $model;
    }

    public bool $status = false;
    public string $message = '';
    public int $id;

    public function check(array $array)
    {
        $this->model = $this->findWhere('code', $array['code']);
        if ($this->isExpired()) {
            $this->status = false;
            $this->message = tr('this_coupon_is_expired');
        } else if ($this->isFinishedUsage()) {
            $this->status = false;
            $this->message = tr('this_coupon_is_finished');
        } else if ($this->checkOrderValue($array['order_value'])) {
            $this->status = false;
            $this->message = tr('this_coupon_is_need_minimum') . ' ' . $this->model->usage_limit;
        } else if ($this->isUserByUser()) {
            $this->status = false;
            $this->message = tr('this_coupon_is_used_by_this_user');
        } else {
            $this->status = true;
        }
    }

    private function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->model->expired_at);
    }

    private function isFinishedUsage(): bool
    {
        return $this->model->times_used == $this->model->usage_count || $this->model->times_used >= $this->model->usage_count;
    }

    private function checkOrderValue($value): bool
    {
        return $this->model->usage_limit > $value;
    }

    private function isUserByUser(): bool
    {
        $userUsageCount = CouponUser::query()->where('coupon_id', $this->model->id)->where('user_id', sanctum()->id)->first();
        return $userUsageCount && $this->model->usage_per_customer <= $userUsageCount->times_used;
    }

    public function save($id): bool
    {
        $this->find($id);
        $relation = CouponUser::query()->where('coupon_id', $id)->where('user_id', sanctum()->id)->first();
        DB::beginTransaction();
        try {
            $this->model->increment('times_used');
            $relation ? $relation->increment('times_used') : CouponUser::query()->create([
                'coupon_id' => $id,
                'user_id' => sanctum()->id,
                'times_used' => 1,
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }
}
