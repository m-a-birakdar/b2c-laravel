<?php

namespace Modules\Order\Http\Controllers\CoApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Order\Interfaces\CoApi\V1\OrderRepositoryInterface;
use Modules\Order\Transformers\CoApi\V1\ShowOrderResource;

class OrderController extends Controller
{
    public OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show($id): ShowOrderResource
    {
        return ShowOrderResource::make($this->repository->show($id));
    }

    public function toDelivered($id): MainResource
    {
        return MainResource::make(null, $this->repository->toDelivered($id));
    }
}
