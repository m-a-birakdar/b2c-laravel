<?php

namespace Modules\Order\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Cart\Entities\Cart;
use Modules\Coupon\Entities\Coupon;
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

    public CouponRepository $couponRepository;

    private OrderRequest $orderRequest;

    private Cart|null $cart = null;

    private float $totalAmountAfterCoupon, $totalAmountToInsert;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    private function checkCoupon()
    {
        $this->couponRepository = new CouponRepository();
        if ($this->orderRequest->has('coupon_code')){
            $this->couponRepository->check([
                'code' => $this->orderRequest->input('coupon_code'),
                'order_value' => $this->orderRequest->totalPriceAmount,
            ]);
            $this->totalAmountAfterCoupon = $this->couponRepository->model && $this->couponRepository->status ? $this->setAmountAfterCoupon() : $this->orderRequest->totalPriceAmount;
        } else {
            $this->totalAmountAfterCoupon = $this->orderRequest->totalPriceAmount;
        }
    }

    private function setAmountAfterCoupon(): float
    {
        $total = $this->orderRequest->totalPriceAmount;
        $this->totalAmountAfterCoupon = $total - ($this->couponRepository->model->type == \Modules\Coupon\Enums\TypeEnum::FIXED->value ? $this->couponRepository->model->value : ($total * $this->couponRepository->model->value / 100));
        return (double) number_format($this->totalAmountAfterCoupon, 2);
    }

    private function saveCoupon()
    {
        if ($this->couponRepository->model->exists)
            $this->couponRepository->save();
    }

    public function save(OrderRequest $request): bool
    {
        $this->orderRequest = $request;
        $this->cart = $this->orderRequest->cart;
        $this->checkCoupon();
        $this->totalAmountToInsert = $this->cart->shipping_amount + $this->totalAmountAfterCoupon;
        $this->executeInTransaction(function () {
            $this->createOrder();
            $this->createOrderItems();
            $this->removeCartItems();
            $this->cart->delete();
            $this->walletTransaction();
            $this->saveCoupon();
        });
        ProductStatisticsJob::dispatch(array_column($this->orderRequest->orderItems, 'product_id'), sanctum()->id, StatisticsEnum::Order, time());
        SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_pending'), $this->model->user_id, 'high');
        return true;
    }

    private function walletTransaction()
    {
        if($this->orderRequest->input('payment_method') == OrderPaymentMethodEnum::Wallet->value)
            $this->make($this->model, TypeEnum::WITHDRAWAL, $this->totalAmountToInsert, $this->orderRequest->wallet);
    }

    private function removeCartItems()
    {
        foreach ($this->cart->items as $item)
            $item->delete();
    }

    private function createOrderItems()
    {
        foreach ($this->orderRequest->orderItems as $orderItem)
            $this->model->items()->create(array_merge($orderItem, ['order_id' => $this->model->id]));
    }

    private function createOrder()
    {
        $this->model = $this->model->create([
            'sku' => mt_rand(1000000000, 9999999999),
            'user_id' => sanctum()->id,
            'coupon_id' => $this->couponRepository->model->id ?? null,
            'address_id' => $this->orderRequest->address_id,
            'payment_method' => $this->orderRequest->payment_method,
            'items_count' => $this->cart->items_count,
            'items_qty' => $this->cart->items_qty,
            'shipping_amount' => $this->cart->shipping_amount,
            'items_amount' => $this->orderRequest->totalPriceAmount,
            'discount_amount' => $this->orderRequest->totalDiscountAmount,
            'total_amount' => $this->totalAmountToInsert
        ]);
    }

    public function index(): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->model->with('products:id,thumbnail')->where('user_id', sanctum()->id)->orderByDesc('id')->simplePaginate(null, ['id', 'sku', 'status', 'total_amount', 'created_at',]);
    }

    public function show($orderId): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->model->with([
            'products:id,thumbnail,title'
        ])->withExists('review')->findOrFail($orderId);
    }

    public function review($array): \Illuminate\Database\Eloquent\Model
    {
        $this->find($array['order_id'], null, ['id']);
        return $this->model->review()->create(array_merge($array, ['user_id' => sanctum()->id]));
    }
}
