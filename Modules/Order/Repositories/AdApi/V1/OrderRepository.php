<?php

namespace Modules\Order\Repositories\AdApi\V1;

use App\Repositories\DBTransactionRepository;
use App\Traits\SocketTrait;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Str;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Order\Entities\Order;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Interfaces\AdApi\V1\OrderRepositoryInterface;

class OrderRepository extends DBTransactionRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait, SocketTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    public function index($status)
    {
        $status = match (ucfirst($status)){
            OrderStatusEnum::Pending->name => OrderStatusEnum::Pending->value,
            OrderStatusEnum::Processing->name => OrderStatusEnum::Processing->value,
            OrderStatusEnum::Shipment->name => OrderStatusEnum::Shipment->value,
            OrderStatusEnum::Delivered->name => OrderStatusEnum::Delivered->value,
            OrderStatusEnum::Cancelled->name => OrderStatusEnum::Cancelled->value,
        };
        return $this->model->with([
            'user:id,name,phone', 'address:id,address', 'shipment:id'
        ])->where('status', $status)->simplePaginate(null, ['id', 'sku', 'user_id', 'address_id', 'status', 'total_amount', 'created_at']);
    }

    public function show($id)
    {
        return $this->findWhere('id', $id, [
            'user:id,name,phone', 'address:id,address', 'products:id,thumbnail,title'
        ]);
    }

    public function toProcessing($id): bool|int
    {
        $this->model = $this->find($id, ['address:id,city_id,address'], ['id', 'status', 'user_id', 'payment_method', 'address_id', 'shipping_amount']);
        $this->model->update([
            'status' => OrderStatusEnum::Processing
        ]);
        $this->socket();
        SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_processing'), $this->model->user_id, 'high');
        return true;
    }

    private function socket()
    {
        if (env("SOCKET"))
            $this->emit('new_order', [
                'order_id' => $this->model->id,
                'payment_method' => Str::snake($this->model->payment_method_human),
                'address' => $this->model->address->address,
                'city_id' => $this->model->address->city_id,
                'tenant' => tenant()->id,
                'shipping_amount' => $this->model->shipping_amount ?? 10,
            ]);
    }

    public function toCancel($id): bool|int
    {
        $this->model = $this->find($id, null, ['id', 'status', 'user_id']);
        $this->model->update([
            'status' => OrderStatusEnum::Cancelled
        ]);
        SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_cancel'), $this->model->user_id, 'high');
         return true;
    }

    public function toShipment($array): bool|int
    {
        $this->model = $this->findWhere('id', $array['order_id'], [], ['id', 'status', 'user_id', 'address_id']);
        return $this->executeInTransaction(function () use ($array) {
            $this->setShipment($array['courier_id']);
            $this->model->update([
                'status' => OrderStatusEnum::Shipment
            ]);
            SendPrivateNotificationJob::dispatch(nCo('order', 'title'), nCo('order.to_shipment'), $array['courier_id'], 'high', 'courier');
            SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_shipment'), $this->model->user_id, 'high');
            return true;
        });
    }

    public function setShipment($courierId)
    {
        $this->model->shipment()->create([
            'track_number'  => mt_rand(1000000000, 9999999999),
            'customer_id'   => $this->model->user_id,
            'courier_id'    => $courierId,
            'address_id'    => $this->model->address_id,
        ]);
    }
}
