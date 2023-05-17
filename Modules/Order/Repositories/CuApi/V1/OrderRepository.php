<?php

namespace Modules\Order\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Order\Enums\OrderPaymentMethodEnum;
use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;
use Modules\Order\Interfaces\CuApi\V1\OrderRepositoryInterface;
use Modules\Order\Entities\Order;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TypeEnum;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait;

    public Order|null $model;
    public Wallet $wallet;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    /**
     * @throws ApiErrorException
     */
    public function save(OrderRequest $request): bool
    {
        DB::beginTransaction();
        $cart = $request->cart;
        try {
            $this->model = $this->model->create([
                'sku' => mt_rand(1000000000, 9999999999),
                'user_id' => sanctum()->id,
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
            if($request->input('payment_method') == OrderPaymentMethodEnum::Wallet->value){
                $this->wallet = $request->wallet;
                $this->transaction();
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function transaction()
    {
        $this->wallet->update([
            'balance' => $this->wallet->balance - $this->model->total_amount
        ]);
        $this->model->transaction()->create([
            'wallet_id' => $this->wallet->id, 'type' => TypeEnum::WITHDRAWAL->value, 'amount' => $this->model->total_amount
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
        return $this->find($orderId, [
            'products:id,thumbnail,title'
        ]);
    }
}
