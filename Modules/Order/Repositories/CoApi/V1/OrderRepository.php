<?php

namespace Modules\Order\Repositories\CoApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Interfaces\CoApi\V1\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait;

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
        $this->model = $this->findWhere('id', $id, [], ['id', 'status']);
        return $this->model->update([
            'status' => OrderStatusEnum::Delivered
        ]);
    }
}
