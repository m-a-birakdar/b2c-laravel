<?php

namespace Modules\Order\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Repositories\CuApi\V1\CouponRepository;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Order\Enums\OrderPaymentMethodEnum;
use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;
use Modules\Order\Interfaces\CuApi\V1\OrderRepositoryInterface;
use Modules\Order\Entities\Order;
use Modules\Product\Enums\StatisticsEnum;
use Modules\Product\Jobs\ProductStatisticsJob;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Traits\WalletOperationsTrait;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait, WalletOperationsTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    private $totalAmountAfterCoupon;
    private $coupon;

    private function checkCoupon($request)
    {
        if ($request->has('coupon_code')){
            $coupon = new CouponRepository();
            $coupon->check([
                'code' => $request->input('coupon_code'),
                'order_value' => $request->totalPriceAmount,
            ]);
            if ($coupon->status){
                $this->coupon = $coupon->model;
                $this->setAmountAfterCoupon($request->totalPriceAmount);
            } else {
                $this->totalAmountAfterCoupon = $request->totalPriceAmount;
            }
        }
    }

    private function setAmountAfterCoupon($total)
    {
        if ($this->coupon->type == \Modules\Coupon\Enums\TypeEnum::FIXED->value){
            $this->totalAmountAfterCoupon = $total - $this->coupon->value;
        } else {
            $this->totalAmountAfterCoupon = $total - ($total * $this->coupon->value / 100);
        }
    }

    private function saveCoupon()
    {
        if ($this->coupon)
            ( new CouponRepository )->save($this->coupon->id);
    }

    /**
     * @throws ApiErrorException
     */
    public function save(OrderRequest $request): bool
    {
        $this->checkCoupon($request);
        DB::beginTransaction();
        $cart = $request->cart;
        try {
            $this->model = $this->model->create([
                'sku' => mt_rand(1000000000, 9999999999),
                'user_id' => sanctum()->id,
                'coupon_id' => $this->coupon->id ?? null,
                'address_id' => $request->address_id,
                'payment_method' => $request->payment_method,
                'items_count' => $cart->items_count,
                'items_qty' => $cart->items_qty,
                'shipping_amount' => $cart->shipping_amount,
                'items_amount' => $request->totalPriceAmount,
                'discount_amount' => $request->totalDiscountAmount,
                'total_amount' => $cart->shipping_amount + $request->totalPriceAmount
            ]);
            $productsWithOrderId = collect($request->orderItems)->map(function ($product) {
                return array_merge($product, ['order_id' => $this->model->id]);
            })->toArray();
            $this->model->items()->insert($productsWithOrderId);
            $cart->items()->delete();
            $cart->delete();
            if($request->input('payment_method') == OrderPaymentMethodEnum::Wallet->value)
                $this->make($this->model, TypeEnum::WITHDRAWAL->value, $this->model->total_amount, $request->wallet);
            $this->saveCoupon();
            DB::commit();
            ProductStatisticsJob::dispatch(array_column($request->orderItems, 'product_id'), sanctum()->id, StatisticsEnum::Order, time());
            SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_pending'), $this->model->user_id, 'high');
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function index(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getWhere('user_id', sanctum()->id, [
            'products:id,thumbnail'
        ], ['id', 'sku', 'status', 'total_amount', 'created_at',]);
    }

    public function show($orderId): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->model->with([
            'products:id,thumbnail,title'
        ])->withExists('review')->findOrFail($orderId);
    }

    public function review($array): \Illuminate\Database\Eloquent\Model
    {
        $this->find($array['order_id']);
        return $this->model->review()->create(array_merge($array, ['user_id' => sanctum()->id]));
    }
}
