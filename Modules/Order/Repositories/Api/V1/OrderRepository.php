<?php

namespace Modules\Order\Repositories\Api\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Repositories\Api\V1\CartRepository;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Interfaces\Api\V1\OrderRepositoryInterface;
use Modules\Order\Entities\Order;
use Modules\Shipment\Entities\Shipment;
use Modules\Shipment\Enums\ShipmentStatusEnum;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    /**
     * @throws ApiErrorException
     */
    public function save(): bool
    {
        DB::beginTransaction();
        try {
            $cart = (new CartRepository())->findWhere('user_id', sanctum()->id, [
                'products:id,price,discount'
            ]);
            $orderItems = [];
            $totalPriceAmount = 0;
            $totalDiscountAmount = 0;
            foreach ($cart->products as $product) {
                $totalPrice = $product->pivot->quantity * $product->price;
                $totalDiscount = $product->pivot->quantity * $product->discount;
                $totalPriceAmount += $totalPrice;
                $totalDiscountAmount += $totalDiscount;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->price,
                    'total_price' => $totalPrice,
                    'discount' => $totalDiscount,
                ];
            }
            $shippingAmount = $cart->shipping_amount;
            $this->model = $this->model->create([
                'sku' => mt_rand(1000000000, 9999999999),
                'user_id' => sanctum()->id,
                'status' => OrderStatusEnum::Shipment,
                'items_count' => $cart->items_count,
                'items_qty' => $cart->items_qty,
                'shipping_amount' => $cart->shipping_amount,
                'items_amount' => $totalPriceAmount,
                'discount_amount' => $totalDiscountAmount,
                'total_amount' => $shippingAmount + $totalPriceAmount
            ]);
            $productsWithOrderId = collect($orderItems)->map(function ($product) use ($orderItems) {
                return array_merge($product, ['order_id' => $this->model->id]);
            })->toArray();
            $this->model->items()->insert($productsWithOrderId);
            $cart->items()->delete();
            $cart->delete();
            $this->setShipment();
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function setShipment()
    {
        // Todo will removed
        Shipment::create([
            'track_number' => mt_rand(1000000000, 9999999999),
            'user_id' => sanctum()->id,
            'status' => ShipmentStatusEnum::NotYetShipped,
            'address_id' => sanctum()->addresses()->first()->id,
            'order_id' => $this->model->id
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
