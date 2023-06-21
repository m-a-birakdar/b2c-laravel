<?php

namespace Modules\Coupon\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Carbon\Carbon;
use Modules\Coupon\Entities\CouponUser;
use Modules\Coupon\Interfaces\CuApi\V1\CouponRepositoryInterface;
use Modules\Coupon\Entities\Coupon;

class CouponRepository extends DBTransactionRepository implements CouponRepositoryInterface
{
    use BaseRepositoryTrait;

    public Coupon|null $model;
    public CouponUser|null $couponUser;

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
        if ($this->model){
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
        $this->couponUser = ( new CouponUserRepository() )->first($id);
        return $this->executeInTransaction(function () {
            $this->model->increment('times_used');
            $this->couponUser ? $this->couponUser->increment('times_used') : $this->couponUser->update([
                'coupon_id' => $this->model->id,
                'user_id' => sanctum()->id,
                'times_used' => 1,
            ]);
            return true;
        });
    }
}
