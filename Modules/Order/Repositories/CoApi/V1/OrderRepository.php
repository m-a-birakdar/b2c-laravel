<?php

namespace Modules\Order\Repositories\CoApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Order\Entities\Order;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Interfaces\CoApi\V1\OrderRepositoryInterface;
use Modules\Order\Jobs\NotifyToReviewOrderJob;
use Modules\User\Jobs\Co\AddShipmentAmountToCourierWallet;
use Modules\Wallet\Repositories\CuApi\V1\WalletRepository;
use Modules\Wallet\Traits\WalletOperationsTrait;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait, WalletOperationsTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    public function show($id)
    {
        return $this->findWhere('id', $id, [
            'user:id,name,phone', 'address:id,address', 'products:id,thumbnail,title'
        ]);
    }

    public function toDelivered($id): bool|int
    {
        $this->model = $this->findWhere('id', $id, [], ['id', 'status', 'user_id', 'shipping_amount']);
        $this->model->update([
            'status' => OrderStatusEnum::Delivered
        ]);
        SendPrivateNotificationJob::dispatch(nCu('order', 'title'), nCu('order.to_delivered'), $this->model->user_id, 'high');
        NotifyToReviewOrderJob::dispatch($id, $this->model->user_id)->delay(now()->addHours(2));
        AddShipmentAmountToCourierWallet::dispatch($this->model->shipment, $this->model->shipping_amount ?? 10, ( new WalletRepository() )->show());
        return true;
    }
}
