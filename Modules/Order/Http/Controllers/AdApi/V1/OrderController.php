<?php

namespace Modules\Order\Http\Controllers\AdApi\V1;

use Illuminate\Routing\Controller;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Interfaces\AdApi\V1\OrderRepositoryInterface;

class OrderController extends Controller
{
    public OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($status)
    {
        $enums = array_map('strtolower', array_column(OrderStatusEnum::cases(), 'name'));
        abort_if(! in_array($status, $enums), 404);
        return $this->repository->index($status);
    }
}
