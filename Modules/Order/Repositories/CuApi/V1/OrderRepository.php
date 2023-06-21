<?php

namespace Modules\Order\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Cart\Entities\Cart;
use Modules\Coupon\Repositories\CuApi\V1\CouponRepository;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Order\Enums\OrderPaymentMethodEnum;
use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;
use Modules\Order\Interfaces\CuApi\V1\OrderRepositoryInterface;
use Modules\Order\Entities\Order;
use Modules\Product\Enums\StatisticsEnum;
use Modules\Product\Jobs\ProductStatisticsJob;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Traits\WalletOperationsTrait;

class OrderRepository extends DBTransactionRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait, WalletOperationsTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    private $totalAmountAfterCoupon;
    private $coupon;

    private function checkCoupon()
    {
        if ($this->orderRequest->has('coupon_code')){
            $coupon = new CouponRepository();
            $coupon->check([
                'code' => $this->orderRequest->input('coupon_code'),
                'order_value' => $this->orderRequest->totalPriceAmount,
            ]);
            if ($coupon->status){
                $this->coupon = $coupon->model;
                $this->setAmountAfterCoupon($this->orderRequest->totalPriceAmount);
            } else {
                $this->totalAmountAfterCoupon = $this->orderRequest->totalPriceAmount;
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

    private OrderRequest $orderRequest;
    private Cart $cart;

    public function save(OrderRequest $request): bool
    {
        $this->orderRequest = $request;
        $this->cart = $this->orderRequest->cart;
        $this->checkCoupon();
        return $this->executeInTransaction(function () {
            $this->createOrder();
            $productsWithOrderId = collect($this->orderRequest->orderItems)->map(function ($product) {
                return array_merge($product, ['order_id' => $this->model->id]);
            })->toArray();
            $this->model->items()->insert($productsWithOrderId);
            $this->cart->items()->delete();
            $this->cart->delete();
            if($this->orderRequest->input('payment_method') == OrderPaymentMethodEnum::Wallet->value)
                $this->make($this->model, TypeEnum::WITHDRAWAL->value, $this->model->total_amount, $this->orderRequest->wallet);
            $this->saveCoupon();
            ProductStatisticsJob::dispatch(array_column($this->orderRequest->orderItems, 'product_id'), sanctum()->id, StatisticsEnum::Order, time());
            SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_pending'), $this->model->user_id, 'high');
            return true;
        });
    }

    private function createOrder()
    {
        $this->model = $this->model->create([
            'sku' => mt_rand(1000000000, 9999999999),
            'user_id' => sanctum()->id,
            'coupon_id' => $this->coupon->id ?? null,
            'address_id' => $this->orderRequest->address_id,
            'payment_method' => $this->orderRequest->payment_method,
            'items_count' => $this->cart->items_count,
            'items_qty' => $this->cart->items_qty,
            'shipping_amount' => $this->cart->shipping_amount,
            'items_amount' => $this->orderRequest->totalPriceAmount,
            'discount_amount' => $this->orderRequest->totalDiscountAmount,
            'total_amount' => $this->cart->shipping_amount + $this->orderRequest->totalPriceAmount
        ]);
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
