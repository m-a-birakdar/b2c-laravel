<?php

namespace Modules\Order\Repositories\AdApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Interfaces\AdApi\V1\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    public function index($status)
    {
        return $this->model->all();
    }

    public function change($status)
    {
        // TODO: Implement change() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }
}
